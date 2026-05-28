<?php

namespace App\Http\Controllers;

use App\Models\HomeSlider;
use Illuminate\Http\Request;

class HomeSliderController extends Controller
{
    // ✅ عرض كل السلايدرات
    public function allHomeSliders()
    {
        $sliders = HomeSlider::latest()->get();
        return view('admin.home_slider.all_home_slider', compact('sliders'));
    }

    // ✅ صفحة إضافة سلايدر جديد
    public function addHomeSlider()
    {
        return view('admin.home_slider.add_home_slider');
    }

    // ✅ تخزين سلايدر جديد
    public function storeHomeSlider(Request $request)
    {
        $request->validate([
            'title'           => 'nullable|string|max:255',
            'description'     => 'nullable|string',
            'attachment_type' => 'required|in:image,video',
            'attachment'      => 'required|file|max:51200', // كحد أقصى 50 ميجا للفيديو/الصورة
        ], [
            'attachment_type.required' => 'حقل نوع المرفق مطلوب',
            'attachment.required'      => 'يجب رفع ملف الصورة أو الفيديو',
            'attachment.file'          => 'المرفق يجب أن يكون ملفًا صالحًا',
            'attachment.max'           => 'حجم الملف يجب ألا يتجاوز 50 ميجابايت',
        ]);

        $save_path = null;
        if ($request->hasFile('attachment')) {
            $file = $request->file('attachment');
            $extension = strtolower($file->getClientOriginalExtension());
            
            // تحقق إضافي بناءً على النوع المختار
            if ($request->attachment_type == 'image') {
                if (!in_array($extension, ['jpg', 'jpeg', 'png', 'gif', 'webp'])) {
                    return back()->withErrors(['attachment' => 'الملف المرفوع يجب أن يكون صورة صالحة (jpg, jpeg, png, gif, webp)'])->withInput();
                }
            } else {
                if (!in_array($extension, ['mp4', 'avi', 'mov', 'wmv', 'webm'])) {
                    return back()->withErrors(['attachment' => 'الملف المرفوع يجب أن يكون فيديو صالح (mp4, avi, mov, wmv, webm)'])->withInput();
                }
            }

            $filename = date('YmdHi') . '_' . uniqid() . '.' . $extension;
            $file->move(public_path('upload/home_sliders/'), $filename);
            $save_path = 'upload/home_sliders/' . $filename;
        }

        HomeSlider::create([
            'title'           => $request->title,
            'description'     => $request->description,
            'attachment_type' => $request->attachment_type,
            'attachment_path' => $save_path,
        ]);

        $notification = array(
            'message' => 'تمت إضافة السلايدر بنجاح',
            'alert-type' => 'success'
        );

        return redirect()->route('all.home_sliders')->with($notification);
    }

    // ✅ صفحة تعديل السلايدر
    public function editHomeSlider($id)
    {
        $slider = HomeSlider::findOrFail($id);
        return view('admin.home_slider.edit_home_slider', compact('slider'));
    }

    // ✅ تحديث السلايدر
    public function updateHomeSliderStore(Request $request)
    {
        $request->validate([
            'id'              => 'required|exists:home_sliders,id',
            'title'           => 'nullable|string|max:255',
            'description'     => 'nullable|string',
            'attachment_type' => 'required|in:image,video',
            'attachment'      => 'nullable|file|max:51200',
        ], [
            'attachment_type.required' => 'حقل نوع المرفق مطلوب',
            'attachment.file'          => 'المرفق يجب أن يكون ملفًا صالحًا',
            'attachment.max'           => 'حجم الملف يجب ألا يتجاوز 50 ميجابايت',
        ]);

        $slider = HomeSlider::findOrFail($request->id);
        $save_path = $slider->attachment_path;

        if ($request->hasFile('attachment')) {
            $file = $request->file('attachment');
            $extension = strtolower($file->getClientOriginalExtension());

            // تحقق إضافي بناءً على النوع المختار
            if ($request->attachment_type == 'image') {
                if (!in_array($extension, ['jpg', 'jpeg', 'png', 'gif', 'webp'])) {
                    return back()->withErrors(['attachment' => 'الملف المرفوع يجب أن يكون صورة صالحة (jpg, jpeg, png, gif, webp)'])->withInput();
                }
            } else {
                if (!in_array($extension, ['mp4', 'avi', 'mov', 'wmv', 'webm'])) {
                    return back()->withErrors(['attachment' => 'الملف المرفوع يجب أن يكون فيديو صالح (mp4, avi, mov, wmv, webm)'])->withInput();
                }
            }

            // حذف الملف القديم إذا كان موجوداً
            if ($slider->attachment_path && file_exists(public_path($slider->attachment_path))) {
                unlink(public_path($slider->attachment_path));
            }

            $filename = date('YmdHi') . '_' . uniqid() . '.' . $extension;
            $file->move(public_path('upload/home_sliders/'), $filename);
            $save_path = 'upload/home_sliders/' . $filename;
        }

        $slider->update([
            'title'           => $request->title,
            'description'     => $request->description,
            'attachment_type' => $request->attachment_type,
            'attachment_path' => $save_path,
        ]);

        $notification = array(
            'message' => 'تم تعديل السلايدر بنجاح',
            'alert-type' => 'success'
        );

        return redirect()->route('all.home_sliders')->with($notification);
    }

    // ✅ حذف السلايدر
    public function deleteHomeSlider($id)
    {
        $slider = HomeSlider::findOrFail($id);

        if ($slider->attachment_path && file_exists(public_path($slider->attachment_path))) {
            unlink(public_path($slider->attachment_path));
        }

        $slider->delete();

        $notification = array(
            'message' => 'تم حذف السلايدر بنجاح',
            'alert-type' => 'success'
        );

        return redirect()->route('all.home_sliders')->with($notification);
    }
}
