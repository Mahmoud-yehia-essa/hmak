<?php

namespace App\Http\Controllers;

use App\Models\Service;

use Illuminate\Http\Request;
use Intervention\Image\ImageManager;
use Intervention\Image\Facades\Image;
use Intervention\Image\Drivers\Gd\Driver; // Use GD driver (or use Intervention\Image\Drivers\Imagick\Driver for Imagick)



class ServiceController extends Controller
{






     public function allService()
    {
        $values = Service::latest()->get();




        return view('admin.service.all_service',compact('values'));
    }



     public function addService()
    {




        return view('admin.service.add_service');
    }





        public function editService($id){

            $value = Service::findOrFail($id);

        return view('admin.service.edit_service',compact('value'));
    }




    public function storeService(Request $request)
    {



        $request->validate([
    'title'     => 'required|string|max:255',
    'title_en'  => 'required|string|max:255',
    'des'       => 'required|string',
    'des_en'    => 'required|string',
    'photo'     => 'required|image|mimes:jpeg,png,jpg,gif|max:2048',
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

    'photo.required'    => '⚠️ الرجاء اضافة صورة',
    'photo.image'       => '⚠️ تأكد من أن الملف صورة صحيحة',
    'photo.mimes'       => '⚠️ الصورة يجب أن تكون jpeg, png, jpg, أو gif',
    'photo.max'         => '⚠️ حجم الصورة يجب ألا يتعدى 2MB',
]);


        if ($request->hasFile('photo')) {
            $image = $request->file('photo');
            $name_gen = hexdec(uniqid()) . '.' . $image->getClientOriginalExtension();

            // Ensure directory exists
            $path = public_path('upload/service/');
            if (!file_exists($path)) {
                mkdir($path, 0777, true);
            }

            $imageManager = new ImageManager(new Driver()); // Use new Imagick\Driver() for Imagick
            // Process and save image
            // $imageResized = $imageManager->read($image)->resize(364, 176);

            $imageResized = $imageManager->read($image);

            $imageResized->save($path . $name_gen);

            $save_url = 'upload/service/' . $name_gen;
        }

        // Insert category
        Service::create([

              'title'     => $request->title,
    'title_en'  => $request->title_en,
    'des'       => $request->des,
    'des_en'    => $request->des_en,

      'more_des'       => $request->more_des,
    'more_des_en'    => $request->more_des_en,
    'photo'     => $save_url,

        ]);


        $notification = array(
            'message' => 'تم الاضافة  ',
            'alert-type' => 'success'
        );

        return redirect()->route('all.service')->with($notification);
    }



       public function editServiceStore(Request $request){



$request->validate([
    'title'     => 'required|string|max:255',
    'title_en'  => 'required|string|max:255',
    'des'       => 'required|string',
    'des_en'    => 'required|string',
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



        $path = public_path('upload/service/');

        $imageManager = new ImageManager(new Driver()); // Use new Imagick\Driver() for Imagick
        // Process and save image
        // $imageResized = $imageManager->read($image)->resize(364, 176);
        $imageResized = $imageManager->read($image);

        $imageResized->save($path . $name_gen);

        $save_url = 'upload/service/' . $name_gen;


        if (file_exists($old_img)) {
           unlink($old_img);
        }
        Service::findOrFail($id)->update([
    'title'     => $request->title,
    'title_en'  => $request->title_en,
    'des'       => $request->des,
    'des_en'    => $request->des_en,
       'more_des'       => $request->more_des,
    'more_des_en'    => $request->more_des_en,
    'photo'     => $save_url,
]);
       $notification = array(
            'message' => 'تم التعديل',
            'alert-type' => 'success'
        );
        // return redirect()->route('sponsor.add.cate')->with($notification);
        return redirect()->route('all.service')->with($notification);

        } else {
         Service::findOrFail($id)->update([
    'title'     => $request->title,
    'title_en'  => $request->title_en,
    'des'       => $request->des,
    'des_en'    => $request->des_en,
       'more_des'       => $request->more_des,
    'more_des_en'    => $request->more_des_en,
    // 'photo'     => $save_url,
]);
       $notification = array(
            'message' => 'تم التعديل ',
            'alert-type' => 'success'
        );
        return redirect()->route('all.service')->with($notification);
        } // end else
    }// End Method





    public function deleteService($id){
        $value = Service::findOrFail($id);
        $img = $value->photo;

        // unlink($img );

        if ($value->photo && file_exists(public_path($value->photo))) {
            unlink(public_path($value->photo));
        }
        Service::findOrFail($id)->delete();
        $notification = array(
            'message' => 'تم الحذف ',
            'alert-type' => 'success'
        );
        return redirect()->route('all.service')->with($notification);

        // return redirect()->back()->with($notification);
    }// End Method




    public function serviceInactive($id){
        Service::findOrFail($id)->update(['status' => 'inactive']);
        $notification = array(
            'message' => ' غير مفعل',
            'alert-type' => 'success'
        );
        return redirect()->back()->with($notification);
    }// End Method
      public function serviceActive($id){
        Service::findOrFail($id)->update(['status' => 'active']);
        $notification = array(
            'message' => 'مفعل',
            'alert-type' => 'success'
        );
        return redirect()->back()->with($notification);
    }



}
