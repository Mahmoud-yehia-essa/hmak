<?php

namespace App\Http\Controllers\Frontend;

use App\Models\Home;
use App\Models\Companywork;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class FrontCompanyWorkController extends Controller
{
public function showPortfolio(){

        $home = Home::latest()->get();
        // $about = About::latest()->get();
        $companywork = Companywork::latest()->get();


        return view('frontend.pages.portfolio',compact('home','companywork'));


    }


        public function showServicesPortfolio($id)
    {

        $home = Home::latest()->get();
        $companywork = Companywork::find($id);
        return view('frontend.pages.portfolio_single',compact('home','companywork'));
    }
}
