<?php

namespace App\Http\Controllers\Frontend;

use App\Models\Home;
use App\Models\Service;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class FrontServiceController extends Controller
{
     public function showServices()
    {

        $home = Home::latest()->get();
        $service = Service::latest()->get();
        return view('frontend.pages.service',compact('home','service'));
    }


      public function showServicesDetails($id)
    {

        $home = Home::latest()->get();
        $service = Service::find($id);
        return view('frontend.pages.service_single',compact('home','service'));
    }


}
