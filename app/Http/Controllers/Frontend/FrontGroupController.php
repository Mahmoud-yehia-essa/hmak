<?php

namespace App\Http\Controllers\Frontend;

use App\Models\Group;
use App\Models\GroupSubject;
use App\Models\GroupComment;
use App\Models\GroupSubjectReaction;
use App\Models\Home;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;

class FrontGroupController extends Controller
{
    /**
     * Display a listing of all groups.
     */
    public function index(Request $request)
    {
        $home = Home::latest()->get();
        $search = $request->input('search');

        $query = Group::withCount(['users', 'subjects']);

        if ($search) {
            $query->where('title', 'like', '%' . $search . '%')
                  ->orWhere('description', 'like', '%' . $search . '%');
        }

        $groups = $query->latest()->get();

        $joinedGroupIds = [];
        if (Auth::check()) {
            $joinedGroupIds = Auth::user()->newsEyes()->pluck('id')->toArray(); // Wait, let's get joined groups via pivot
            $joinedGroupIds = Auth::user()->belongsToMany(Group::class, 'group_users', 'user_id', 'group_id')->pluck('groups.id')->toArray();
        }

        return view('frontend.hmak.pages.groups.index', compact('home', 'groups', 'joinedGroupIds', 'search'));
    }

    /**
     * Show the group creation form.
     */
    public function create()
    {
        if (!Auth::check()) {
            return redirect()->route('show.user.login')->with('error', 'يجب تسجيل الدخول أولاً لإنشاء مجموعة.');
        }
        $home = Home::latest()->get();
        return view('frontend.hmak.pages.groups.create', compact('home'));
    }

    /**
     * Store a newly created group in database.
     */
    public function store(Request $request)
    {
        if (!Auth::check()) {
            return redirect()->route('show.user.login')->with('error', 'يجب تسجيل الدخول أولاً لإنشاء مجموعة.');
        }

        $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
            'status' => 'required|in:open,closed',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        ], [
            'title.required' => 'حقل اسم المجموعة مطلوب.',
            'status.required' => 'حقل نوع الخصوصية مطلوب.',
            'image.max' => 'حجم الصورة يجب ألا يتجاوز 2 ميجابايت.',
            'image.image' => 'يجب أن يكون الملف المرفوع صورة.',
        ]);

        $inviteCode = null;
        if ($request->status === 'closed') {
            $inviteCode = strtoupper(Str::random(8));
        }

        $imagePath = null;
        if ($request->hasFile('image')) {
            $file = $request->file('image');
            $filename = time() . '_' . uniqid() . '.' . $file->getClientOriginalExtension();
            $file->move(public_path('upload/groups'), $filename);
            $imagePath = 'upload/groups/' . $filename;
        }

        $group = Group::create([
            'title' => $request->title,
            'description' => $request->description,
            'image_path' => $imagePath,
            'status' => $request->status,
            'invite_code' => $inviteCode,
            'admin_user_id' => Auth::id(),
        ]);

        // Automatically join the creator to the group
        $group->users()->attach(Auth::id());

        return redirect()->route('front.groups.show', $group->id)
                         ->with('success', 'تم إنشاء المجموعة بنجاح وتفعيل العضوية بها!');
    }

    /**
     * Show a single group profile, stats, members, and subjects.
     */
    public function show($id)
    {
        $home = Home::latest()->get();
        $group = Group::with(['admin'])->withCount(['users', 'subjects'])->findOrFail($id);

        $isMember = false;
        if (Auth::check()) {
            $isMember = $group->isMember(Auth::id());
        }

        // Paginate subjects
        $subjects = $group->subjects()
                          ->with(['user', 'comments.user', 'reactions'])
                          ->latest()
                          ->paginate(10);

        // Get group members
        $members = $group->users()->take(12)->get();

        return view('frontend.hmak.pages.groups.show', compact('home', 'group', 'isMember', 'subjects', 'members'));
    }

    /**
     * Join an open or closed group.
     */
    public function join(Request $request, $id)
    {
        $group = Group::findOrFail($id);

        if (!Auth::check()) {
            return redirect()->route('show.user.login')->with('error', 'يجب تسجيل الدخول أولاً للانضمام للمجموعة.');
        }

        if ($group->isMember(Auth::id())) {
            return redirect()->back()->with('info', 'أنت عضو بالفعل في هذه المجموعة.');
        }

        if ($group->status === 'closed') {
            $request->validate([
                'invite_code' => 'required|string',
            ], [
                'invite_code.required' => 'رمز الدعوة مطلوب للمجموعات المغلقة.',
            ]);

            if (strtoupper($request->invite_code) !== strtoupper($group->invite_code)) {
                return redirect()->back()->with('error', 'رمز الدعوة المدخل غير صحيح.');
            }
        }

        $group->users()->attach(Auth::id());

        // Notify the group administrator if a different user joins
        $adminUser = $group->admin;
        if ($adminUser && (int)Auth::id() !== (int)$group->admin_user_id) {
            $adminUser->notify(new \App\Notifications\GroupJoinNotification($group, Auth::user()));
        }

        return redirect()->back()->with('success', 'تهانينا! لقد انضممت للمجموعة بنجاح.');
    }

    /**
     * Leave a group.
     */
    public function leave($id)
    {
        $group = Group::findOrFail($id);

        if (!Auth::check()) {
            return redirect()->route('show.user.login');
        }

        if (!$group->isMember(Auth::id())) {
            return redirect()->back()->with('error', 'أنت لست عضواً في هذه المجموعة.');
        }

        $group->users()->detach(Auth::id());

        return redirect()->route('front.groups.index')->with('success', 'تم مغادرة المجموعة بنجاح.');
    }

    /**
     * Create a new subject inside the group.
     */
    public function storeSubject(Request $request, $id)
    {
        $group = Group::findOrFail($id);

        if (!Auth::check()) {
            return redirect()->route('show.user.login');
        }

        if (!$group->isMember(Auth::id())) {
            return redirect()->back()->with('error', 'يجب أن تكون عضواً لتستطيع إضافة موضوع.');
        }

        $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'required|string',
            'attachment' => 'nullable|file|mimes:jpeg,png,jpg,gif,mp4,mov,ogg,qt,mp3,wav,m4a|max:20480',
        ], [
            'title.required' => 'حقل عنوان الموضوع مطلوب.',
            'description.required' => 'حقل تفاصيل الموضوع مطلوب.',
            'attachment.max' => 'حجم المرفق يجب ألا يتجاوز 20 ميجابايت.',
            'attachment.mimes' => 'نوع الملف المرفق غير مدعوم.',
        ]);

        $attachmentPath = null;
        $attachmentType = null;

        if ($request->hasFile('attachment')) {
            $file = $request->file('attachment');
            $mime = $file->getMimeType();

            if (str_starts_with($mime, 'image/')) {
                $attachmentType = 'image';
            } elseif (str_starts_with($mime, 'video/')) {
                $attachmentType = 'video';
            } elseif (str_starts_with($mime, 'audio/')) {
                $attachmentType = 'audio';
            }

            $filename = time() . '_' . uniqid() . '.' . $file->getClientOriginalExtension();
            $file->move(public_path('upload/group_subjects'), $filename);
            $attachmentPath = 'upload/group_subjects/' . $filename;
        }

        $subject = GroupSubject::create([
            'user_id' => Auth::id(),
            'group_id' => $group->id,
            'title' => $request->title,
            'description' => $request->description,
            'attachment_type' => $attachmentType,
            'attachment_path' => $attachmentPath,
        ]);

        // Notify the group administrator if a different user posts a subject
        $adminUser = $group->admin;
        if ($adminUser && (int)Auth::id() !== (int)$group->admin_user_id) {
            $adminUser->notify(new \App\Notifications\GroupNewSubjectNotification($subject));
        }

        return redirect()->back()->with('success', 'تم نشر الموضوع بنجاح في المجموعة!');
    }

    /**
     * Like a subject via AJAX.
     */
    public function likeSubject($id)
    {
        if (!Auth::check()) {
            return response()->json(['success' => false, 'message' => 'يجب تسجيل الدخول للتفاعل مع المواضيع.']);
        }

        $subject = GroupSubject::findOrFail($id);
        $userId = Auth::id();

        $reaction = GroupSubjectReaction::where('group_subject_id', $subject->id)
                                        ->where('user_id', $userId)
                                        ->first();

        if ($reaction) {
            if ($reaction->type === 'like') {
                // User is toggling their like OFF
                $reaction->delete();
                $subject->decrement('likes');
                $status = 'none';
            } else {
                // User is switching from dislike to like
                $reaction->update(['type' => 'like']);
                $subject->decrement('dislikes');
                $subject->increment('likes');
                $status = 'liked';
            }
        } else {
            // New like reaction
            GroupSubjectReaction::create([
                'group_subject_id' => $subject->id,
                'user_id' => $userId,
                'type' => 'like',
            ]);
            $subject->increment('likes');
            $status = 'liked';
        }

        // Just to be sure, sync counts in DB
        $subject->likes = max(0, $subject->likes);
        $subject->dislikes = max(0, $subject->dislikes);
        $subject->save();

        return response()->json([
            'success' => true,
            'likes' => $subject->likes,
            'dislikes' => $subject->dislikes,
            'status' => $status
        ]);
    }

    /**
     * Dislike a subject via AJAX.
     */
    public function dislikeSubject($id)
    {
        if (!Auth::check()) {
            return response()->json(['success' => false, 'message' => 'يجب تسجيل الدخول للتفاعل مع المواضيع.']);
        }

        $subject = GroupSubject::findOrFail($id);
        $userId = Auth::id();

        $reaction = GroupSubjectReaction::where('group_subject_id', $subject->id)
                                        ->where('user_id', $userId)
                                        ->first();

        if ($reaction) {
            if ($reaction->type === 'dislike') {
                // User is toggling their dislike OFF
                $reaction->delete();
                $subject->decrement('dislikes');
                $status = 'none';
            } else {
                // User is switching from like to dislike
                $reaction->update(['type' => 'dislike']);
                $subject->decrement('likes');
                $subject->increment('dislikes');
                $status = 'disliked';
            }
        } else {
            // New dislike reaction
            GroupSubjectReaction::create([
                'group_subject_id' => $subject->id,
                'user_id' => $userId,
                'type' => 'dislike',
            ]);
            $subject->increment('dislikes');
            $status = 'disliked';
        }

        // Just to be sure, sync counts in DB
        $subject->likes = max(0, $subject->likes);
        $subject->dislikes = max(0, $subject->dislikes);
        $subject->save();

        return response()->json([
            'success' => true,
            'likes' => $subject->likes,
            'dislikes' => $subject->dislikes,
            'status' => $status
        ]);
    }

    /**
     * Get list of users who reacted to a subject (AJAX popup).
     */
    public function getReactions($id, Request $request)
    {
        $request->validate([
            'type' => 'required|in:like,dislike',
        ]);

        $subject = GroupSubject::findOrFail($id);
        
        $reactions = $subject->reactions()
                             ->where('type', $request->type)
                             ->with('user')
                             ->latest()
                             ->get();

        $users = $reactions->map(function ($reaction) {
            $user = $reaction->user;
            if ($user) {
                return [
                    'name' => $user->fname . ' ' . $user->lname,
                    'photo' => (!empty($user->photo) && $user->photo != 'non') ? url('upload/user_images/' . $user->photo) : url('upload/no_image.jpg'),
                ];
            }
            return [
                'name' => 'عضو مجهول',
                'photo' => url('upload/no_image.jpg'),
            ];
        });

        return response()->json([
            'success' => true,
            'users' => $users,
        ]);
    }

    /**
     * Post a comment on a subject.
     */
    public function storeComment(Request $request, $subjectId)
    {
        $subject = GroupSubject::findOrFail($subjectId);
        $group = $subject->group;

        if (!Auth::check()) {
            return redirect()->route('show.user.login');
        }

        if (!$group->isMember(Auth::id())) {
            return redirect()->back()->with('error', 'يجب أن تكون عضواً لتستطيع التعليق.');
        }

        $request->validate([
            'content' => 'required_without:attachment|nullable|string',
            'attachment' => 'nullable|file|mimes:jpeg,png,jpg,gif,mp4,mov,ogg,qt,mp3,wav,m4a|max:10240',
        ], [
            'content.required_without' => 'يرجى كتابة نص التعليق أو إرفاق ملف وسائط.',
            'attachment.max' => 'حجم ملف التعليق يجب ألا يتجاوز 10 ميجابايت.',
            'attachment.mimes' => 'نوع الملف المرفق غير مدعوم في التعليقات.',
        ]);

        $attachmentPath = null;
        $attachmentType = null;

        if ($request->hasFile('attachment')) {
            $file = $request->file('attachment');
            $mime = $file->getMimeType();

            if (str_starts_with($mime, 'image/')) {
                $attachmentType = 'image';
            } elseif (str_starts_with($mime, 'video/')) {
                $attachmentType = 'video';
            } elseif (str_starts_with($mime, 'audio/')) {
                $attachmentType = 'audio';
            }

            $filename = time() . '_' . uniqid() . '.' . $file->getClientOriginalExtension();
            $file->move(public_path('upload/group_comments'), $filename);
            $attachmentPath = 'upload/group_comments/' . $filename;
        }

        $comment = GroupComment::create([
            'group_subject_id' => $subject->id,
            'user_id' => Auth::id(),
            'content' => $request->content,
            'attachment_type' => $attachmentType,
            'attachment_path' => $attachmentPath,
        ]);

        if ($request->ajax()) {
            $user = Auth::user();
            return response()->json([
                'success' => true,
                'comment' => [
                    'id' => $comment->id,
                    'content' => $comment->content,
                    'attachment_type' => $comment->attachment_type,
                    'attachment_path' => $comment->attachment_path ? asset($comment->attachment_path) : null,
                    'created_at' => $comment->created_at->diffForHumans(),
                    'user' => [
                        'name' => $user->fname . ' ' . $user->lname,
                        'photo' => (!empty($user->photo) && $user->photo != 'non') ? url('upload/user_images/' . $user->photo) : url('upload/no_image.jpg'),
                    ]
                ]
            ]);
        }

        return redirect()->back()->with('success', 'تم إضافة تعليقك بنجاح!');
    }

    /**
     * Delete a comment on a subject.
     */
    public function deleteComment($id)
    {
        if (!Auth::check()) {
            return response()->json(['success' => false, 'message' => 'يجب تسجيل الدخول لحذف التعليق.']);
        }

        $comment = GroupComment::findOrFail($id);

        // Check ownership
        if ($comment->user_id !== Auth::id()) {
            return response()->json(['success' => false, 'message' => 'غير مصرح لك بحذف هذا التعليق.']);
        }

        // Delete attachment file if exists
        if ($comment->attachment_path && file_exists(public_path($comment->attachment_path))) {
            unlink(public_path($comment->attachment_path));
        }

        $subjectId = $comment->group_subject_id;
        $comment->delete();

        return response()->json([
            'success' => true,
            'subject_id' => $subjectId,
            'message' => 'تم حذف التعليق بنجاح!'
        ]);
    }

    /**
     * Delete a subject in a group.
     */
    public function deleteSubject($id)
    {
        if (!Auth::check()) {
            return response()->json(['success' => false, 'message' => 'يجب تسجيل الدخول لحذف الموضوع.']);
        }

        $subject = GroupSubject::findOrFail($id);

        // Check ownership
        if ((int)$subject->user_id !== (int)Auth::id()) {
            return response()->json(['success' => false, 'message' => 'غير مصرح لك بحذف هذا الموضوع.']);
        }

        // Delete subject attachment if exists
        if ($subject->attachment_path && file_exists(public_path($subject->attachment_path))) {
            unlink(public_path($subject->attachment_path));
        }

        // Delete comments attachments if exist
        foreach ($subject->comments as $comment) {
            if ($comment->attachment_path && file_exists(public_path($comment->attachment_path))) {
                unlink(public_path($comment->attachment_path));
            }
        }

        $subject->delete();

        return response()->json([
            'success' => true,
            'message' => 'تم حذف الموضوع بنجاح!'
        ]);
    }

    /**
     * Delete a group (only by group administrator).
     */
    public function deleteGroup($id)
    {
        if (!Auth::check()) {
            return redirect()->route('show.user.login');
        }

        $group = Group::findOrFail($id);

        // Check if the user is the administrator of the group
        if ((int)$group->admin_user_id !== (int)Auth::id()) {
            return redirect()->back()->with('error', 'غير مصرح لك بحذف هذه المجموعة.');
        }

        // Delete group cover image if exists
        if ($group->image_path && file_exists(public_path($group->image_path))) {
            unlink(public_path($group->image_path));
        }

        // Delete all subject and comment attachments of this group
        foreach ($group->subjects as $subject) {
            // Delete subject attachment
            if ($subject->attachment_path && file_exists(public_path($subject->attachment_path))) {
                unlink(public_path($subject->attachment_path));
            }

            // Delete comment attachments
            foreach ($subject->comments as $comment) {
                if ($comment->attachment_path && file_exists(public_path($comment->attachment_path))) {
                    unlink(public_path($comment->attachment_path));
                }
            }
        }

        // Delete group (cascade deletes group_users, subjects, comments, reactions in DB)
        $group->delete();

        return redirect()->route('front.groups.index')->with('success', 'تم حذف المجموعة بنجاح.');
    }

    /**
     * Remove a member from a group (only by group administrator).
     */
    public function removeMember($id, $userId)
    {
        if (!Auth::check()) {
            return response()->json(['success' => false, 'message' => 'يجب تسجيل الدخول أولاً.']);
        }

        $group = Group::findOrFail($id);

        // Check if the current user is the administrator of the group
        if ((int)$group->admin_user_id !== (int)Auth::id()) {
            return response()->json(['success' => false, 'message' => 'غير مصرح لك بإجراء هذا التعديل.']);
        }

        // Check if the administrator is trying to remove themselves
        if ((int)$userId === (int)Auth::id()) {
            return response()->json(['success' => false, 'message' => 'لا يمكنك إزالة نفسك كمدير للمجموعة.']);
        }

        // Detach the user from the group
        $group->users()->detach($userId);

        return response()->json([
            'success' => true,
            'message' => 'تم إزالة العضو من المجموعة بنجاح!'
        ]);
    }

    /**
     * Show a single subject page.
     */
    public function showSubject($id)
    {
        $home = Home::latest()->get();
        // Load the subject along with its group, group admin, comments and reactions
        $subject = GroupSubject::with(['user', 'group.admin', 'comments.user', 'reactions'])
            ->findOrFail($id);
            
        $group = $subject->group;
        $group->loadCount(['users', 'subjects']);

        $isMember = false;
        if (Auth::check()) {
            $isMember = $group->isMember(Auth::id());
        }

        // Get group members
        $members = $group->users()->take(12)->get();

        return view('frontend.hmak.pages.groups.show_subject', compact('home', 'group', 'subject', 'isMember', 'members'));
    }
}

