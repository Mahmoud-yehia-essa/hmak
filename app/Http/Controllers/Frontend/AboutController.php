<?php

namespace App\Http\Controllers\Frontend;

use App\Models\Home;
use App\Models\About;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class AboutController extends Controller
{

    public function showAbout(){

        $home = Home::latest()->get();
        $about = About::latest()->get();


        return view('frontend.hmak.pages.about',compact('home','about'));
    }

}
