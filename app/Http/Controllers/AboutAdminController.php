<?php

namespace App\Http\Controllers;

use App\Models\About;
use Illuminate\Http\Request;

class AboutAdminController extends Controller
{


     public function allAbout()
    {
        $values = About::latest()->get();




        return view('admin.company_about.all_company_about',compact('values'));
    }



     public function addAbout()
    {




        return view('admin.company_about.add_company_about');
    }





        public function editAbout($id){

            $value = About::findOrFail($id);

        return view('admin.company_about.edit_company_about',compact('value'));
    }




    public function storeAbout(Request $request)
    {



        $request->validate([
    'title'     => 'required|string|max:255',
    'title_en'  => 'required|string|max:255',
    'des'       => 'required|string',
    'des_en'    => 'required|string',
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


]);



        // Insert category
        About::create([

              'title'     => $request->title,
    'title_en'  => $request->title_en,
    'des'       => $request->des,
    'des_en'    => $request->des_en,

        ]);


        $notification = array(
            'message' => 'تمت الاضافة ',
            'alert-type' => 'success'
        );

        return redirect()->route('all.about')->with($notification);
    }



       public function editAboutStore(Request $request){



$request->validate([
    'title'     => 'required|string|max:255',
    'title_en'  => 'required|string|max:255',
    'des'       => 'required|string',
    'des_en'    => 'required|string',
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




]);



        $id = $request->id;


         About::findOrFail($id)->update([
    'title'     => $request->title,
    'title_en'  => $request->title_en,
    'des'       => $request->des,
    'des_en'    => $request->des_en,
    // 'photo'     => $save_url,
]);
       $notification = array(
            'message' => 'تم التعديل ',
            'alert-type' => 'success'
        );
        return redirect()->route('all.about')->with($notification);
    }// End Method





    public function deleteAbout($id){
        $value = About::findOrFail($id);

        // unlink($img );


        About::findOrFail($id)->delete();
        $notification = array(
            'message' => 'تم الحذف ',
            'alert-type' => 'success'
        );
        return redirect()->route('all.about')->with($notification);

        // return redirect()->back()->with($notification);
    }// End Method






}
