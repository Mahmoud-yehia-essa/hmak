<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class NotificationDashboardController extends Controller
{


     public function setNotificationRead($notificationId)
    {



       $current_user_id = Auth::User()->id;

       $user = User::find($current_user_id);


$notification = $user->unreadNotifications()->where('id', $notificationId)->first();
if ($notification) {
    $notification->markAsRead();


    if($notification->type == "App\Notifications\UserServiceNotification")
    {

       // return "OrderComplete";
    //    $order_id = $notification->data['order_id'];


        return redirect()->route('all.user_services');

    }
    else if($notification->type == "App\Notifications\ContactUsNotification")
    {


        // $vendorId = $notification->data['vendorId'];


        return redirect()->route('all.contact.us');


        //$this->vendorId
    }
    else if($notification->type == "App\Notifications\NewsEyeStatusNotification")
    {
        return redirect()->route('show.user.dashboard', ['tab' => 'my-news']);
    }
    else if($notification->type == "App\Notifications\GroupJoinNotification" || $notification->type == "App\Notifications\GroupNewSubjectNotification")
    {
        $groupId = $notification->data['group_id'] ?? null;
        if ($groupId) {
            return redirect()->route('front.groups.show', $groupId);
        }
        return redirect()->route('front.groups.index');
    }
    else
    {
        if (Auth::user()->role === 'admin') {
            return redirect()->route('dashboard');
        }
        return redirect()->route('show.user.dashboard');
    }

  //  return $notification->type;





} else {
    // Handle case where the notification with the specified ID was not found
    // This could be logging an error, showing a message to the user, etc.
}









    }



}
