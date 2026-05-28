<?php

namespace App\Http\Controllers;

use App\Models\NewsEye;
use App\Notifications\NewsEyeStatusNotification;
use Illuminate\Http\Request;

class AdminNewsEyeController extends Controller
{
    /**
     * Display a listing of all news eye submissions.
     */
    public function index()
    {
        // Load the submissions with user details, ordered by latest
        $newsEyes = NewsEye::with('user')->latest('id')->get();
        
        return view('admin.news_eye.all_news_eye', compact('newsEyes'));
    }

    /**
     * Update the status of a news eye submission.
     */
    public function updateStatus(Request $request)
    {
        $request->validate([
            'id' => 'required|exists:news_eyes,id',
            'status' => 'required|in:pending,approved,rejected',
            'rejection_reason' => 'required_if:status,rejected|nullable|string',
        ]);

        $newsEye = NewsEye::findOrFail($request->id);
        $newsEye->update([
            'status' => $request->status,
            'rejection_reason' => $request->status == 'rejected' ? $request->rejection_reason : null,
        ]);

        // Send status update notification to the user
        if (in_array($request->status, ['approved', 'rejected'])) {
            if ($newsEye->user) {
                $newsEye->user->notify(new NewsEyeStatusNotification($newsEye));
            }
        }

        $statusText = $request->status == 'approved' ? 'قبول' : 'رفض';

        return back()->with('success', 'تم ' . $statusText . ' الخبر بنجاح.');
    }

    /**
     * Remove the specified news eye submission.
     */
    public function destroy($id)
    {
        $newsEye = NewsEye::findOrFail($id);
        
        // Delete attachment file from public if exists
        if ($newsEye->attachment_path && file_exists(public_path($newsEye->attachment_path))) {
            @unlink(public_path($newsEye->attachment_path));
        }

        $newsEye->delete();

        return back()->with('success', 'تم حذف الخبر بنجاح.');
    }
}
