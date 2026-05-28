<?php

use App\Models\User;
use App\Models\Group;
use App\Models\GroupSubject;
use App\Models\GroupSubjectReaction;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Hash;

uses(RefreshDatabase::class);

beforeEach(function () {
    // Create a user and make them a member of a group
    $this->user = User::create([
        'fname' => 'احمد',
        'lname' => 'علي',
        'email' => 'ahmed@example.com',
        'password' => Hash::make('password'),
        'photo' => 'profile.jpg',
    ]);

    $this->group = Group::create([
        'title' => 'مجموعة برمجية',
        'description' => 'مجموعة لمناقشة لغات البرمجة',
        'status' => 'open',
    ]);

    // Join group
    $this->group->users()->attach($this->user->id);

    // Create a subject
    $this->subject = GroupSubject::create([
        'user_id' => $this->user->id,
        'group_id' => $this->group->id,
        'title' => 'موضوع تجريبي عن Laravel',
        'description' => 'هذا الموضوع يهدف لاختبار التفاعلات.',
        'likes' => 0,
        'dislikes' => 0,
    ]);
});

it('allows logged-in user to like a subject and increments count', function () {
    $this->actingAs($this->user);

    $response = $this->post(route('front.groups.like_subject', $this->subject->id));

    $response->assertStatus(200)
             ->assertJson([
                 'success' => true,
                 'likes' => 1,
                 'dislikes' => 0,
                 'status' => 'liked'
             ]);

    $this->assertDatabaseHas('group_subject_reactions', [
        'group_subject_id' => $this->subject->id,
        'user_id' => $this->user->id,
        'type' => 'like'
    ]);

    // Toggle like OFF
    $response = $this->post(route('front.groups.like_subject', $this->subject->id));
    $response->assertStatus(200)
             ->assertJson([
                 'success' => true,
                 'likes' => 0,
                 'dislikes' => 0,
                 'status' => 'none'
             ]);

    $this->assertDatabaseMissing('group_subject_reactions', [
        'group_subject_id' => $this->subject->id,
        'user_id' => $this->user->id,
    ]);
});

it('allows logged-in user to switch reaction from like to dislike', function () {
    $this->actingAs($this->user);

    // First, like
    $this->post(route('front.groups.like_subject', $this->subject->id));

    // Then, dislike
    $response = $this->post(route('front.groups.dislike_subject', $this->subject->id));

    $response->assertStatus(200)
             ->assertJson([
                 'success' => true,
                 'likes' => 0,
                 'dislikes' => 1,
                 'status' => 'disliked'
             ]);

    $this->assertDatabaseHas('group_subject_reactions', [
        'group_subject_id' => $this->subject->id,
        'user_id' => $this->user->id,
        'type' => 'dislike'
    ]);
});

it('returns list of users who reacted to the subject', function () {
    // Add reaction directly
    GroupSubjectReaction::create([
        'group_subject_id' => $this->subject->id,
        'user_id' => $this->user->id,
        'type' => 'like'
    ]);

    $response = $this->get(route('front.groups.subject_reactions', $this->subject->id) . '?type=like');

    $response->assertStatus(200)
             ->assertJson([
                 'success' => true,
                 'users' => [
                     [
                         'name' => 'احمد علي',
                         'photo' => url('upload/user_images/profile.jpg')
                     ]
                 ]
             ]);
});

it('redirects guests attempting to create a group to login page', function () {
    // Attempt GET create page
    $responseGet = $this->get(route('front.groups.create'));
    $responseGet->assertRedirect(route('show.user.login'));

    // Attempt POST store action
    $responsePost = $this->post(route('front.groups.store'), [
        'title' => 'مجموعة جديدة للزوار',
        'status' => 'open'
    ]);
    $responsePost->assertRedirect(route('show.user.login'));
});

it('splits full name into fname and lname on frontend user registration', function () {
    $response = $this->post(route('add.user.front.store'), [
        'name' => 'محمود يحيى عيسى',
        'email' => 'mahmoud@example.com',
        'phone' => '+96594959092',
        'password' => 'Pass1234',
    ]);

    $response->assertRedirect(route('show.user.dashboard'));

    $this->assertDatabaseHas('users', [
        'fname' => 'محمود',
        'lname' => 'يحيى عيسى',
        'email' => 'mahmoud@example.com',
        'phone' => '+96594959092',
    ]);
});

it('allows comment owner to delete their comment, but forbids others', function () {
    // Create another user
    $otherUser = User::create([
        'fname' => 'خالد',
        'lname' => 'سعيد',
        'email' => 'khaled@example.com',
        'password' => Hash::make('password'),
    ]);

    // Create a comment by the owner ($this->user)
    $comment = \App\Models\GroupComment::create([
        'group_subject_id' => $this->subject->id,
        'user_id' => $this->user->id,
        'content' => 'تعليق تجريبي من صاحب الموضوع',
    ]);

    // Try to delete the comment as Guest -> should redirect to login
    $response = $this->delete(route('front.groups.delete_comment', $comment->id));
    $response->assertRedirect(route('show.user.login'));

    // Try to delete as the other user -> should return error JSON
    $this->actingAs($otherUser);
    $response = $this->deleteJson(route('front.groups.delete_comment', $comment->id));
    $response->assertStatus(200)
             ->assertJson([
                 'success' => false,
                 'message' => 'غير مصرح لك بحذف هذا التعليق.'
             ]);

    // Delete as the owner ($this->user) -> should succeed
    $this->actingAs($this->user);
    $response = $this->deleteJson(route('front.groups.delete_comment', $comment->id));
    $response->assertStatus(200)
             ->assertJson([
                 'success' => true,
                 'subject_id' => $this->subject->id,
                 'message' => 'تم حذف التعليق بنجاح!'
             ]);

    $this->assertDatabaseMissing('group_comments', [
        'id' => $comment->id
    ]);
});

it('allows subject owner to delete their subject, but forbids others', function () {
    // Create another user
    $otherUser = User::create([
        'fname' => 'خالد',
        'lname' => 'سعيد',
        'email' => 'khaled@example.com',
        'password' => Hash::make('password'),
    ]);

    // Try to delete the subject as Guest -> should redirect to login
    $response = $this->delete(route('front.groups.delete_subject', $this->subject->id));
    $response->assertRedirect(route('show.user.login'));

    // Try to delete as the other user -> should return error JSON
    $this->actingAs($otherUser);
    $response = $this->deleteJson(route('front.groups.delete_subject', $this->subject->id));
    $response->assertStatus(200)
             ->assertJson([
                 'success' => false,
                 'message' => 'غير مصرح لك بحذف هذا الموضوع.'
             ]);

    // Delete as the owner ($this->user) -> should succeed
    $this->actingAs($this->user);
    $response = $this->deleteJson(route('front.groups.delete_subject', $this->subject->id));
    $response->assertStatus(200)
             ->assertJson([
                 'success' => true,
                 'message' => 'تم حذف الموضوع بنجاح!'
             ]);

    $this->assertDatabaseMissing('group_subjects', [
        'id' => $this->subject->id
    ]);
});

it('sets admin_user_id to the creator of the group on store', function () {
    $this->actingAs($this->user);

    $response = $this->post(route('front.groups.store'), [
        'title' => 'مجموعة برمجية جديدة',
        'description' => 'وصف المجموعة الجديدة',
        'status' => 'open',
    ]);

    $group = Group::where('title', 'مجموعة برمجية جديدة')->first();
    expect($group)->not->toBeNull();
    expect((int)$group->admin_user_id)->toEqual((int)$this->user->id);
    expect($group->admin->id)->toEqual($this->user->id);
});

it('allows group administrator to delete the group, but forbids others', function () {
    // Create another user
    $otherUser = User::create([
        'fname' => 'خالد',
        'lname' => 'سعيد',
        'email' => 'khaled@example.com',
        'password' => Hash::make('password'),
    ]);

    // Set admin_user_id of our test group
    $this->group->admin_user_id = $this->user->id;
    $this->group->save();

    // Try to delete the group as Guest -> should redirect to login
    $response = $this->delete(route('front.groups.delete_group', $this->group->id));
    $response->assertRedirect(route('show.user.login'));

    // Try to delete as the other user -> should redirect/back with error
    $this->actingAs($otherUser);
    $response = $this->delete(route('front.groups.delete_group', $this->group->id));
    $response->assertRedirect();
    
    // The group should still exist in database
    $this->assertDatabaseHas('groups', [
        'id' => $this->group->id
    ]);

    // Delete as the administrator ($this->user) -> should succeed and redirect to groups index
    $this->actingAs($this->user);
    $response = $this->delete(route('front.groups.delete_group', $this->group->id));
    $response->assertRedirect(route('front.groups.index'));

    $this->assertDatabaseMissing('groups', [
        'id' => $this->group->id
    ]);
});

it('allows group administrator to remove a group member, but forbids others', function () {
    // Create another user
    $otherUser = User::create([
        'fname' => 'خالد',
        'lname' => 'سعيد',
        'email' => 'khaled@example.com',
        'password' => Hash::make('password'),
    ]);
    
    // Join the other user to the group
    $this->group->users()->attach($otherUser->id);

    // Set admin_user_id of our test group
    $this->group->admin_user_id = $this->user->id;
    $this->group->save();

    // Try to remove the member as Guest -> should redirect to login
    $response = $this->delete(route('front.groups.remove_member', [$this->group->id, $otherUser->id]));
    $response->assertRedirect(route('show.user.login'));

    // Try to remove as a non-admin user (e.g. $otherUser trying to remove $this->user)
    $this->actingAs($otherUser);
    $response = $this->deleteJson(route('front.groups.remove_member', [$this->group->id, $this->user->id]));
    $response->assertStatus(200)
             ->assertJson([
                 'success' => false,
                 'message' => 'غير مصرح لك بإجراء هذا التعديل.'
             ]);

    // Admin trying to remove themselves -> should fail
    $this->actingAs($this->user);
    $response = $this->deleteJson(route('front.groups.remove_member', [$this->group->id, $this->user->id]));
    $response->assertStatus(200)
             ->assertJson([
                 'success' => false,
                 'message' => 'لا يمكنك إزالة نفسك كمدير للمجموعة.'
             ]);

    // Admin removing other user -> should succeed
    $response = $this->deleteJson(route('front.groups.remove_member', [$this->group->id, $otherUser->id]));
    $response->assertStatus(200)
             ->assertJson([
                 'success' => true,
                 'message' => 'تم إزالة العضو من المجموعة بنجاح!'
             ]);

    // Assert user is no longer a member in DB
    $this->assertFalse($this->group->fresh()->isMember($otherUser->id));
});

it('sends notifications to group admin when someone joins the group or creates a subject', function () {
    // Create another user
    $otherUser = User::create([
        'fname' => 'خالد',
        'lname' => 'سعيد',
        'email' => 'khaled@example.com',
        'password' => Hash::make('password'),
    ]);

    // Set admin_user_id of our test group to $this->user->id
    $this->group->admin_user_id = $this->user->id;
    $this->group->save();

    // 1. Join group as $otherUser -> should notify $this->user
    $this->actingAs($otherUser);
    $response = $this->post(route('front.groups.join', $this->group->id));
    $response->assertRedirect();

    expect($this->user->fresh()->unreadNotifications->count())->toEqual(1);
    $joinNotification = $this->user->fresh()->unreadNotifications->where('type', 'App\Notifications\GroupJoinNotification')->first();
    expect($joinNotification)->not->toBeNull();
    expect($joinNotification->data['group_id'])->toEqual($this->group->id);
    expect($joinNotification->data['user_id'])->toEqual($otherUser->id);
    expect($joinNotification->data['message'])->toContain('انضم المستخدم "خالد سعيد" إلى مجموعتك');

    // 2. Create subject as $otherUser -> should notify $this->user
    $response = $this->post(route('front.groups.store_subject', $this->group->id), [
        'title' => 'موضوع جديد من خالد',
        'description' => 'تفاصيل الموضوع الجديد',
    ]);
    $response->assertRedirect();

    expect($this->user->fresh()->unreadNotifications->count())->toEqual(2);
    $subjectNotification = $this->user->fresh()->unreadNotifications->where('type', 'App\Notifications\GroupNewSubjectNotification')->first();
    expect($subjectNotification)->not->toBeNull();
    expect($subjectNotification->data['group_id'])->toEqual($this->group->id);
    expect($subjectNotification->data['message'])->toContain('بنشر موضوع جديد: "موضوع جديد من خالد"');

    // 3. Mark notification as read via setNotificationRead route
    $this->actingAs($this->user);
    $response = $this->get(route('notification.read', $subjectNotification->id));
    // Redirects to front.groups.show
    $response->assertRedirect(route('front.groups.show', $this->group->id));
    expect($this->user->fresh()->unreadNotifications->count())->toEqual(1);
});





