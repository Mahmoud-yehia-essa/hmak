<?php

namespace App\Http\Controllers\Frontend;

use App\Models\Home;
use App\Models\Planne;
use Illuminate\Http\Request;
use App\Models\PlanneUserRequest;
use App\Http\Controllers\Controller;

class FrontPlanneController extends Controller
{


     public function showPlanne($id){

        $plan = Planne::find($id);
        $home = Home::latest()->get();


        // $about = About::latest()->get();
        // $companywork = Companywork::latest()->get();

        // $companywork = Companywork::latest()->get();

        return view('frontend.pages.planne',compact('home','plan'));


    }




     public function showAllPlanneUser(){

        $planne = Planne::latest()->get();
        $home = Home::latest()->get();


        // $about = About::latest()->get();
        // $companywork = Companywork::latest()->get();

        // $companywork = Companywork::latest()->get();

        return view('frontend.pages.planne_all_user',compact('home','planne'));


    }


      public function storePlanne(Request $request){

         $request->validate([
            'plan_id' => 'required|exists:plannes,id',
            'name'    => 'required|string|max:255',
            // 'email'   => 'required|email',
            'phone'   => 'required|string|max:20',
            'message' => 'nullable|string',
        ]);

        PlanneUserRequest::create([
            'planne_id' => $request->plan_id,
            'name'    => $request->name,
            'email'   => $request->email,
            'phone'   => $request->phone,
            'message' => $request->message,
            'created_at' => now(),
        ]);

        return back()->with('success', 'تم إرسال طلبك بنجاح ✅');
    }







}
