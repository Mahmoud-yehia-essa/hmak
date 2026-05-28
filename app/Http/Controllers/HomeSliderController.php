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

            if ($request->attachment_type == 'video') {
                $this->optimizeVideo(public_path($save_path));
            }
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

            if ($request->attachment_type == 'video') {
                $this->optimizeVideo(public_path($save_path));
            }
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

    /**
     * Optimizes an uploaded video for fast web playback.
     * Compresses quality slightly, scales to max 720p, and moves moov atom to start of file.
     */
    private function optimizeVideo($filePath)
    {
        $ffmpeg = null;
        if (strtoupper(substr(PHP_OS, 0, 3)) === 'WIN') {
            $where = shell_exec('where ffmpeg');
            if ($where) {
                $ffmpeg = 'ffmpeg';
            }
        } else {
            $which = shell_exec('which ffmpeg');
            if ($which) {
                $ffmpeg = trim($which);
            }
        }

        if (!$ffmpeg) {
            $fallbacks = [
                '/opt/homebrew/bin/ffmpeg',
                '/usr/bin/ffmpeg',
                '/usr/local/bin/ffmpeg',
                '/usr/sbin/ffmpeg'
            ];
            foreach ($fallbacks as $path) {
                if (file_exists($path)) {
                    $ffmpeg = $path;
                    break;
                }
            }
        }

        if (!$ffmpeg) {
            return; // FFmpeg is not installed, skip optimization
        }

        $tempPath = $filePath . '.temp.mp4';
        
        // FFmpeg optimization command:
        // -y to overwrite output files
        // -i source video
        // -vcodec libx264 (H.264 video codec)
        // -profile:v main -level 3.1 -pix_fmt yuv420p (broad device support)
        // -crf 26 (lower quality slightly to get a small web-friendly size, 23-28 range)
        // -vf "scale='min(1280,iw)':-2" (downscale to max 720p height, preserving aspect ratio)
        // -movflags +faststart (moves the Moov atom to the front to enable instant streaming)
        // -acodec aac -ab 64k -ar 44100 (compress audio to a light profile suitable for background)
        $command = escapeshellcmd($ffmpeg) . ' -y -i ' . escapeshellarg($filePath) . ' -vcodec libx264 -profile:v main -level 3.1 -crf 26 -pix_fmt yuv420p -vf "scale=\'min(1280,iw)\':-2" -movflags +faststart -acodec aac -ab 64k -ar 44100 ' . escapeshellarg($tempPath) . ' 2>&1';
        
        exec($command, $output, $returnVar);

        if ($returnVar === 0 && file_exists($tempPath) && filesize($tempPath) > 0) {
            unlink($filePath);
            rename($tempPath, $filePath);
        } else {
            if (file_exists($tempPath)) {
                unlink($tempPath);
            }
        }
    }
}
