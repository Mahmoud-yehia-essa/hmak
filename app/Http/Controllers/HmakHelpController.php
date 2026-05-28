<?php

namespace App\Http\Controllers;

use App\Models\HmakHelpCategory;
use App\Models\HmakHelpUserRequest;
use App\Models\HmakHelpAttachment;
use Illuminate\Http\Request;
use Intervention\Image\ImageManager;
use Intervention\Image\Drivers\Gd\Driver;

class HmakHelpController extends Controller
{
    // ==========================================
    // 1. HELP CATEGORIES CRUD
    // ==========================================

    public function allHelpCategories()
    {
        $categories = HmakHelpCategory::latest()->get();
        return view('admin.hmak_help_category.all_categories', compact('categories'));
    }

    public function addHelpCategory()
    {
        return view('admin.hmak_help_category.add_category');
    }

    public function storeHelpCategory(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'image' => 'nullable|image|mimes:jpg,jpeg,png,webp|max:5120', // max 5MB
        ]);

        $save_url = null;

        if ($request->file('image')) {
            $image = $request->file('image');
            $name_gen = date('YmdHi') . '_' . $image->getClientOriginalName();
            $path = public_path('upload/help_category/');

            if (!file_exists($path)) {
                mkdir($path, 0777, true);
            }

            $imageManager = new ImageManager(new Driver());
            $imageResized = $imageManager->read($image);
            $imageResized->save($path . $name_gen);

            $save_url = 'upload/help_category/' . $name_gen;
        }

        HmakHelpCategory::create([
            'name' => $request->name,
            'image_path' => $save_url,
        ]);

        $notification = [
            'message' => 'تم إضافة فئة المساعدات بنجاح',
            'alert-type' => 'success'
        ];

        return redirect()->route('all.help.categories')->with($notification);
    }

    public function editHelpCategory($id)
    {
        $category = HmakHelpCategory::findOrFail($id);
        return view('admin.hmak_help_category.edit_category', compact('category'));
    }

    public function updateHelpCategory(Request $request)
    {
        $request->validate([
            'id' => 'required|exists:hmak_help_categories,id',
            'name' => 'required|string|max:255',
            'image' => 'nullable|image|mimes:jpg,jpeg,png,webp|max:5120', // max 5MB
        ]);

        $category = HmakHelpCategory::findOrFail($request->id);
        $save_url = $category->image_path;

        if ($request->file('image')) {
            if ($category->image_path && file_exists(public_path($category->image_path))) {
                unlink(public_path($category->image_path));
            }

            $image = $request->file('image');
            $name_gen = date('YmdHi') . '_' . $image->getClientOriginalName();
            $path = public_path('upload/help_category/');

            if (!file_exists($path)) {
                mkdir($path, 0777, true);
            }

            $imageManager = new ImageManager(new Driver());
            $imageResized = $imageManager->read($image);
            $imageResized->save($path . $name_gen);

            $save_url = 'upload/help_category/' . $name_gen;
        }

        $category->update([
            'name' => $request->name,
            'image_path' => $save_url,
        ]);

        $notification = [
            'message' => 'تم تعديل فئة المساعدات بنجاح',
            'alert-type' => 'success'
        ];

        return redirect()->route('all.help.categories')->with($notification);
    }

    public function deleteHelpCategory($id)
    {
        $category = HmakHelpCategory::findOrFail($id);

        if ($category->image_path && file_exists(public_path($category->image_path))) {
            unlink(public_path($category->image_path));
        }

        $category->delete();

        $notification = [
            'message' => 'تم حذف فئة المساعدات بنجاح',
            'alert-type' => 'success'
        ];

        return redirect()->route('all.help.categories')->with($notification);
    }

    // ==========================================
    // 2. HELP REQUESTS MODERATION
    // ==========================================

    public function allHelpRequests()
    {
        $requests = HmakHelpUserRequest::with(['user', 'category', 'attachments'])->latest('id')->get();
        return view('admin.hmak_help_request.all_requests', compact('requests'));
    }

    public function updateRequestStatus(Request $request)
    {
        $request->validate([
            'id' => 'required|exists:hmak_help_user_requests,id',
            'status' => 'required|in:pending,approved,rejected',
            'rejection_reason' => 'nullable|string|max:1000',
        ]);

        $helpRequest = HmakHelpUserRequest::findOrFail($request->id);
        $helpRequest->update([
            'status' => $request->status,
            'rejection_reason' => $request->status === 'rejected' ? $request->rejection_reason : null,
        ]);

        $statusText = 'قيد الانتظار';
        if ($request->status == 'approved') {
            $statusText = 'مقبول';
        } elseif ($request->status == 'rejected') {
            $statusText = 'مرفوض';
        }

        $notification = [
            'message' => 'تم تحديث حالة طلب المساعدة إلى ' . $statusText . ' بنجاح',
            'alert-type' => 'success'
        ];

        return back()->with($notification);
    }

    public function deleteHelpRequest($id)
    {
        $helpRequest = HmakHelpUserRequest::findOrFail($id);

        // Delete associated files
        foreach ($helpRequest->attachments as $attachment) {
            if ($attachment->file_path && file_exists(public_path($attachment->file_path))) {
                unlink(public_path($attachment->file_path));
            }
        }

        // cascade delete handles the attachments from DB, but we explicitly delete request
        $helpRequest->delete();

        $notification = [
            'message' => 'تم حذف طلب المساعدة ومرفقاته بنجاح',
            'alert-type' => 'success'
        ];

        return back()->with($notification);
    }
}
