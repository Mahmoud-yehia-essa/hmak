<?php

namespace App\Http\Controllers\Frontend;

use App\Models\Home;
use App\Models\News;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class FrontNewsController extends Controller
{

    public function showNews(Request $request)
    {
        $home = Home::latest()->get();
        $categoryId = $request->query('category_id');
        
        $categories = \App\Models\NewsCategory::latest()->get();
        
        $query = News::where('status', 'active');
        if ($categoryId) {
            $query->where('news_category_id', $categoryId);
            $selectedCategory = \App\Models\NewsCategory::find($categoryId);
        } else {
            $selectedCategory = null;
        }
        
        $news = $query->latest()->get();
        
        return view('frontend.hmak.pages.news', compact('home', 'news', 'categories', 'selectedCategory', 'categoryId'));
    }



     public function showNewsDetails($id)
     {
         $home = Home::latest()->get();
         $news = News::findOrFail($id);
         
         // Check if news was already viewed in this session
         $viewed = session('viewed_news', []);
         if (!in_array($id, $viewed)) {
             $news->increment('views');
             $viewed[] = $id;
             session(['viewed_news' => $viewed]);
         }

         return view('frontend.hmak.pages.news_single', compact('home', 'news'));
     }

    public function searchAjax(Request $request)
    {
        $query = $request->query('query');
        
        if (empty($query) || strlen(trim($query)) < 1) {
            return response()->json([]);
        }
        
        $news = News::with('category')
            ->where('status', 'active')
            ->where(function($q) use ($query) {
                $q->where('title', 'LIKE', '%' . $query . '%')
                  ->orWhere('des', 'LIKE', '%' . $query . '%');
            })
            ->latest()
            ->limit(10)
            ->get();
            
        $formattedNews = $news->map(function($item) {
            return [
                'id' => $item->id,
                'title' => $item->title,
                'photo' => $item->photo ? asset($item->photo) : null,
                'created_at' => $item->created_at ? $item->created_at->diffForHumans() : '',
                'category_name' => $item->category ? $item->category->name : 'أخبار',
                'url' => route('show.news.details', $item->id),
            ];
        });
        
        return response()->json($formattedNews);
    }

}
