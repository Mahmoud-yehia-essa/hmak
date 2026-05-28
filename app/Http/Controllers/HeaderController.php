<?php

namespace App\Http\Controllers;

use App\Models\Header;

use Illuminate\Http\Request;
use Intervention\Image\ImageManager;
use Intervention\Image\Facades\Image;
use Intervention\Image\Drivers\Gd\Driver; // Use GD driver (or use Intervention\Image\Drivers\Imagick\Driver for Imagick)



class HeaderController extends Controller
{


        public function editSHeaderHomeCate(){

            $header = Header::findOrFail(1);

        return view('admin.header.home_header',compact('header'));
    }


    //    public function addSponsorQuestion(){

    //         $getSponsorHome = Sponsor::findOrFail(2);

    //     return view('admin.sponsor.sponsor_home_cate_add',compact('getSponsorHome'));
    // }



       public function editHomeHeaderStore(Request $request){



$request->validate([
    'title'     => 'required|string|max:255',
    'title_en'  => 'required|string|max:255',
    'des'       => 'required|string',
    'des_en'    => 'required|string',
    'video'     => 'required|string|max:500',
    'photo'     => 'image|mimes:jpeg,png,jpg,gif|max:2048',
], [
    'title.required'    => '⚠️ الرجاء اضافة العنوان بالعربية',
    'title.string'      => '⚠️ الرجاء التأكد من كتابة العنوان بشكل صحيح',
    'title.max'         => '⚠️ العنوان لا يجب أن يتعدى 255 حرف',

    'title_en.required' => '⚠️ الرجاء اضافة العنوان بالانجليزية',
    'title_en.string'   => '⚠️ الرجاء التأكد من كتابة العنوان بالانجليزية بشكل صحيح',
    'title_en.max'      => '⚠️ العنوان بالانجليزية لا يجب أن يتعدى 255 حرف',

    'des.required'      => '⚠️ الرجاء اضافة الوصف بالعربية',
    'des.string'        => '⚠️ الرجاء التأكد من كتابة الوصف بالعربية بشكل صحيح',

    'des_en.required'   => '⚠️ الرجاء اضافة الوصف بالانجليزية',
    'des_en.string'     => '⚠️ الرجاء التأكد من كتابة الوصف بالانجليزية بشكل صحيح',

    'video.required'    => '⚠️ الرجاء اضافة رابط الفيديو',
    'video.string'      => '⚠️ الرجاء التأكد من كتابة الرابط بشكل صحيح',
    'video.max'         => '⚠️ الرابط طويل جداً',

    // 'photo.required'    => '⚠️ الرجاء اضافة صورة',
    'photo.image'       => '⚠️ تأكد من أن الملف صورة صحيحة',
    'photo.mimes'       => '⚠️ الصورة يجب أن تكون jpeg, png, jpg, أو gif',
    'photo.max'         => '⚠️ حجم الصورة يجب ألا يتعدى 2MB',
]);



        $id = $request->id;
        $old_img = $request->old_image;
        if ($request->file('photo')) {
        $image = $request->file('photo');
        $name_gen = hexdec(uniqid()).'.'.$image->getClientOriginalExtension();



        $path = public_path('upload/home/header/');

        $imageManager = new ImageManager(new Driver()); // Use new Imagick\Driver() for Imagick
        // Process and save image
        // $imageResized = $imageManager->read($image)->resize(364, 176);
        $imageResized = $imageManager->read($image);

        $imageResized->save($path . $name_gen);

        $save_url = 'upload/home/header/' . $name_gen;


        if (file_exists($old_img)) {
           unlink($old_img);
        }
        Header::findOrFail($id)->update([
    'title'     => $request->title,
    'title_en'  => $request->title_en,
    'des'       => $request->des,
    'des_en'    => $request->des_en,
    'video'     => $request->video,   // بدل link
    'photo'     => $save_url,
]);
       $notification = array(
            'message' => 'تم تعديل الهيدر',
            'alert-type' => 'success'
        );
        // return redirect()->route('sponsor.add.cate')->with($notification);
                return redirect()->back()->with($notification);

        } else {
         Header::findOrFail($id)->update([
    'title'     => $request->title,
    'title_en'  => $request->title_en,
    'des'       => $request->des,
    'des_en'    => $request->des_en,
    'video'     => $request->video,   // بدل link
    // 'photo'     => $save_url,
]);
       $notification = array(
            'message' => 'تم تعديل الهيدر',
            'alert-type' => 'success'
        );
        return redirect()->back()->with($notification);
        } // end else
    }// End Method

}
