<?php

namespace App\Http\Controllers;

use App\Models\News;
use App\Models\User;
use App\Models\Category;
use App\Models\NewsEye;
use App\Models\Group;
use App\Models\SoundLibrary;
use App\Models\HmakHelpUserRequest;
use App\Models\Article;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function showDashboard()
    {
        $users = User::where('role', '!=', 'admin')->latest()->get();
        $newsCount = News::count();
        $totalNewsViews = News::sum('views');
        $newsEyeCount = NewsEye::count();
        $groupsCount = Group::count();
        $soundLibraryCount = SoundLibrary::count();
        $helpRequestsCount = HmakHelpUserRequest::count();
        $categoriesCount = Category::count();
        $articlesCount = Article::count();

        return view('admin.index', compact(
            'users',
            'newsCount',
            'totalNewsViews',
            'newsEyeCount',
            'groupsCount',
            'soundLibraryCount',
            'helpRequestsCount',
            'categoriesCount',
            'articlesCount'
        ));
    }
}
