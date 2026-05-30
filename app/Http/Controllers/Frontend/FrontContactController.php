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
        
        // Generate math captcha
        $num1 = rand(1, 9);
        $num2 = rand(1, 9);
        session(['captcha_num1' => $num1, 'captcha_num2' => $num2]);

        return view('frontend.hmak.pages.contactus', compact('home', 'num1', 'num2'));
    }


      public function storeContactus(Request $request){

        // Honeypot validation
        if ($request->filled('website_url')) {
            if ($request->expectsJson()) {
                return response()->json([
                    'success' => true,
                    'message' => 'تم تسجيل بياناتك بنجاح! سنقوم بإشعارك فور إطلاق النسخة الجديدة.'
                ]);
            }
            return redirect()->route('show.contactus')
                             ->with('success', 'تم إرسال رسالتك بنجاح، شكراً لتواصلك معنا.');
        }

        $user = User::where('role','admin')->get();

        $num1 = session('captcha_num1');
        $num2 = session('captcha_num2');
        $expected = ($num1 !== null && $num2 !== null) ? ($num1 + $num2) : null;

        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email',
            'message' => 'required|string',
            'phone'  => 'required|integer',
            'captcha_answer' => [
                'required',
                'integer',
                function ($attribute, $value, $fail) use ($expected) {
                    if ($expected === null || (int)$value !== $expected) {
                        $fail('إجابة رمز التحقق غير صحيحة، يرجى المحاولة مرة أخرى.');
                    }
                },
            ],
        ], [
            'name.required' => 'الاسم  مطلوب.',
            'name.string' => 'يجب أن يكون الاسم الأول نصًا.',
            'name.max' => 'يجب ألا يزيد الاسم الأول عن 255 حرفًا.',
            'message.required' => 'الرسالة مطلوبه.',
            'email.required' => 'البريد الإلكتروني مطلوب.',
            'email.email' => 'يجب إدخال بريد إلكتروني صالح.',
            'phone.required' => 'يرجى إدخال رقم الهاتف.',
            'phone.integer' => 'الرجاء ادخال رقم الهاتف بشكل صحيح.',
            'captcha_answer.required' => 'يرجى إدخال إجابة التحقق البشري.',
            'captcha_answer.integer' => 'يجب أن تكون إجابة التحقق رقماً.',
        ]);

        // Clear captcha session variables
        session()->forget(['captcha_num1', 'captcha_num2']);

        ContactUs::create([
            'name' => $request->name,
            'email' => $request->email,
            'phone' => $request->phone,
            'message' => $request->message,
        ]);

        Notification::send($user,new ContactUsNotification($request->name));

        if ($request->expectsJson()) {
            return response()->json([
                'success' => true,
                'message' => 'تم تسجيل بياناتك بنجاح! سنقوم بإشعارك فور إطلاق النسخة الجديدة.'
            ]);
        }

        return redirect()->route('show.contactus')
                         ->with('success', 'تم إرسال رسالتك بنجاح، شكراً لتواصلك معنا.');
    }


}
