<?php

namespace App\Http\Controllers;

use App\Models\SocialMedia;
use Illuminate\Http\Request;
use Intervention\Image\ImageManager;
use Intervention\Image\Facades\Image;
use Intervention\Image\Drivers\Gd\Driver;

class SocialmediaController extends Controller
{
    // Show all records
    public function allSocialMedia()
    {
        $values = SocialMedia::latest()->get();
        return view('admin.social_media.all_social_media', compact('values'));
    }

    // Show add form
    public function addSocialMedia()
    {
        return view('admin.social_media.add_social_media');
    }

    // Store new record
    public function storeSocialMedia(Request $request)
    {
        $request->validate([
            'title'     => 'required|string|max:255',
            'title_en'  => 'required|string|max:255',
            'link'      => 'nullable|string|max:500',
            'photo'     => 'nullable|image|mimes:jpg,jpeg,png,webp,svg|max:2048',
        ]);

        $save_url = null;

        // if ($request->file('photo')) {
        //     $image    = $request->file('photo');
        //     $manager  = new ImageManager(new Driver());
        //     $img      = $manager->read($image);

        //     $name_gen = hexdec(uniqid()) . '.' . $image->getClientOriginalExtension();
        //     $save_url = 'upload/social_media/' . $name_gen;
        //     $img->save(public_path($save_url));
        // }

        if ($request->file('photo')) {
    $image    = $request->file('photo');
    $ext      = strtolower($image->getClientOriginalExtension());

    $name_gen = hexdec(uniqid()) . '.' . $ext;
    $save_url = 'upload/social_media/' . $name_gen;

    if ($ext === 'svg') {
        // just move the file, no Intervention
        $image->move(public_path('upload/social_media/'), $name_gen);
    } else {
        $manager  = new ImageManager(new Driver());
        $img      = $manager->read($image->getRealPath());
        $img->save(public_path($save_url));
    }
}

        SocialMedia::create([
            'title'     => $request->title,
            'title_en'  => $request->title_en,
            'link'      => $request->link,
            'photo'     => $save_url,
        ]);

        return redirect()->route('all.social_media')->with('success', 'تمت الإضافة بنجاح');
    }

    // Show edit form
    public function editSocialMedia($id)
    {
        $value = SocialMedia::findOrFail($id);
        return view('admin.social_media.edit_social_media', compact('value'));
    }

    // Update record
    public function updateSocialMedia(Request $request)
    {
        $id       = $request->id;
        $oldImage = $request->old_image;

        $request->validate([
            'title'     => 'required|string|max:255',
            'title_en'  => 'required|string|max:255',
            'link'      => 'nullable|string|max:500',
            'photo'     => 'nullable|image|mimes:jpg,jpeg,png,webp|max:2048',
        ]);

        $save_url = $oldImage;

        if ($request->file('photo')) {
            @unlink($oldImage);
            $image    = $request->file('photo');
            $manager  = new ImageManager(new Driver());
            $img      = $manager->read($image);

            $name_gen = hexdec(uniqid()) . '.' . $image->getClientOriginalExtension();
            $save_url = 'upload/social_media/' . $name_gen;
            $img->save(public_path($save_url));
        }

        SocialMedia::findOrFail($id)->update([
            'title'     => $request->title,
            'title_en'  => $request->title_en,
            'link'      => $request->link,
            'photo'     => $save_url,
        ]);

        return redirect()->route('all.social_media')->with('success', 'تم التحديث بنجاح');
    }

    // Delete record
    public function deleteSocialMedia($id)
    {
        $value = SocialMedia::findOrFail($id);
        if ($value->photo) {
            @unlink($value->photo);
        }
        $value->delete();

        return redirect()->back()->with('success', 'تم الحذف بنجاح');
    }
}
