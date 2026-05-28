<?php

namespace App\Http\Controllers\Frontend;

use App\Models\NewsEye;
use App\Models\NewsEyeRating;
use App\Models\NewsEyeComment;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class FrontNewsEyeController extends Controller
{
    /**
     * Display all approved user-submitted news (أنت عين الخبر)
     */
    public function index(Request $request)
    {
        $newsEyes = NewsEye::with(['user', 'ratings', 'comments'])
            ->where('status', 'approved')
            ->latest()
            ->paginate(12);

        // Fetch top-rated news eye submissions
        $topRated = NewsEye::with(['user', 'ratings', 'comments'])
            ->where('status', 'approved')
            ->withCount('ratings')
            ->withAvg('ratings', 'rating')
            ->orderByDesc('ratings_avg_rating')
            ->orderByDesc('ratings_count')
            ->take(5)
            ->get();

        return view('frontend.hmak.pages.news_eye_index', compact('newsEyes', 'topRated'));
    }

    /**
     * Show a single approved news eye submission with rating & comments
     */
    public function show($id)
    {
        $newsEye = NewsEye::with(['user', 'ratings', 'comments'])
            ->where('status', 'approved')
            ->findOrFail($id);

        // Get related news (other approved submissions)
        $related = NewsEye::with('user')
            ->where('status', 'approved')
            ->where('id', '!=', $id)
            ->latest()
            ->take(5)
            ->get();

        // Check if the visitor has already rated
        $visitorIp = request()->ip();
        $userRating = NewsEyeRating::where('news_eye_id', $id)
            ->where('visitor_ip', $visitorIp)
            ->value('rating');

        return view('frontend.hmak.pages.news_eye_single', compact('newsEye', 'related', 'userRating'));
    }

    /**
     * Submit a rating for a news eye submission (AJAX)
     */
    public function rate(Request $request, $id)
    {
        $request->validate([
            'rating' => 'required|integer|min:1|max:5',
        ]);

        $newsEye = NewsEye::where('status', 'approved')->findOrFail($id);
        $visitorIp = $request->ip();

        // Update or create rating
        NewsEyeRating::updateOrCreate(
            ['news_eye_id' => $newsEye->id, 'visitor_ip' => $visitorIp],
            ['rating' => $request->rating]
        );

        $avgRating = round($newsEye->ratings()->avg('rating'), 1);
        $ratingCount = $newsEye->ratings()->count();

        return response()->json([
            'success' => true,
            'message' => 'تم تسجيل تقييمك بنجاح!',
            'average_rating' => $avgRating,
            'rating_count' => $ratingCount,
            'user_rating' => $request->rating,
        ]);
    }

    /**
     * Submit a comment for a news eye submission
     */
    public function comment(Request $request, $id)
    {
        $request->validate([
            'visitor_name' => 'required|string|max:100',
            'comment'      => 'required|string|max:1000',
        ]);

        $newsEye = NewsEye::where('status', 'approved')->findOrFail($id);

        $comment = NewsEyeComment::create([
            'news_eye_id'  => $newsEye->id,
            'visitor_name' => $request->visitor_name,
            'visitor_ip'   => $request->ip(),
            'comment'      => $request->comment,
            'status'       => 'approved',
        ]);

        return response()->json([
            'success' => true,
            'message' => 'تم نشر تعليقك بنجاح!',
            'comment' => [
                'id'           => $comment->id,
                'visitor_name' => $comment->visitor_name,
                'comment'      => $comment->comment,
                'created_at'   => $comment->created_at->diffForHumans(),
            ],
        ]);
    }
}
