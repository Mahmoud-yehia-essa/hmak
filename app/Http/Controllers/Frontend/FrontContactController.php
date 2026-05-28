<?php

namespace App\Http\Controllers\Frontend;

use App\Models\Home;
use App\Models\User;
use App\Models\ContactUs;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Notifications\ContactUsNotification;
use Illuminate\Support\Facades\Notification;

class FrontContactController extends Controller
{
       public function showContactUs(){
        $home = Home::latest()->get();
        return view('frontend.hmak.pages.contactus',compact('home'));
    }


      public function storeContactus(Request $request){


        $user = User::where('role','admin')->get();


        $request->validate([


            'name' => 'required|string|max:255',
            'email' => 'required|email',

            'message' => 'required|string',

              'phone'  => 'required|integer',


            // 'lname' => 'required|string|max:255',
            // 'email' => 'required|email|unique:users,email',
            // 'password' => 'required|min:6|confirmed',

                    //   'phone'  => 'required|regex:/^\+?[0-9]{7,15}$/',

                    //   'phone'  => 'required',






            // 'password_confirmation' => 'required',
        ], [
            'name.required' => 'الاسم  مطلوب.',
            'name.string' => 'يجب أن يكون الاسم الأول نصًا.',
            'name.max' => 'يجب ألا يزيد الاسم الأول عن 255 حرفًا.',

                        'message.required' => 'الرسالة مطلوبه.',


            // 'lname.required' => 'حقل اسم العائلة مطلوب.',
            // 'lname.string' => 'يجب أن يكون اسم العائلة نصًا.',
            // 'lname.max' => 'يجب ألا يزيد اسم العائلة عن 255 حرفًا.',

            'email.required' => 'البريد الإلكتروني مطلوب.',
            'email.email' => 'يجب إدخال بريد إلكتروني صالح.',






              'role.required' => 'الرجاء اختيار نوع الحساب.',
        'role.not_in' => 'الرجاء اختيار نوع الحساب.',

             'phone.required' => 'يرجى إدخال رقم الهاتف.',


        'phone.integer' => 'الرجاء ادخال رقم الهاتف',

         'phone.required' => 'يرجى إدخال رقم الهاتف.',

        ]);



    ContactUs::create([
            'name' => $request->name,



            'email' => $request->email,

            'phone' => $request->phone,
            'message' => $request->message,



        ]);


    Notification::send($user,new ContactUsNotification($request->name));

                    // return redirect()->route('all.users')->with($notification);

                    // return redirect()->route('show.contactus');

return redirect()->route('show.contactus')
                 ->with('success', 'تم إرسال رسالتك بنجاح، شكراً لتواصلك معنا.');


    }


}
