<?php

namespace App\Http\Controllers\Frontend;

use App\Models\Home;
use Illuminate\Http\Request;
use App\Models\CompanyClient;
use App\Http\Controllers\Controller;

class FrontClientController extends Controller
{

    public function showClient(){

        $home = Home::latest()->get();
        $companyClient = CompanyClient::latest()->get();


        // $about = About::latest()->get();
        // $companywork = Companywork::latest()->get();

        // $companywork = Companywork::latest()->get();

        return view('frontend.pages.clients',compact('home','companyClient'));


    }

}
