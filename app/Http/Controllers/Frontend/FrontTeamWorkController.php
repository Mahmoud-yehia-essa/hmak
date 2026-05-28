<?php

namespace App\Http\Controllers\Frontend;

use App\Models\Home;
use App\Models\TeamWork;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class FrontTeamWorkController extends Controller
{
       public function showTeamWork()
    {

        $home = Home::latest()->get();
        $teamWork = TeamWork::latest()->get();
        return view('frontend.pages.teamwork',compact('home','teamWork'));
    }
}
