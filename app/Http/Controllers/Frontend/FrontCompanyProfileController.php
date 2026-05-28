<?php

namespace App\Http\Controllers\Frontend;

use App\Models\Home;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class FrontCompanyProfileController extends Controller
{
      public function sowCompanyProfile(){

        $home = Home::latest()->get();


        // $about = About::latest()->get();
        // $companywork = Companywork::latest()->get();

        // $companywork = Companywork::latest()->get();

        return view('frontend.pages.company_profile',compact('home'));


    }
}
