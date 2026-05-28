<?php

namespace App\Http\Controllers;

use App\Models\Planne;
use Illuminate\Http\Request;
use App\Models\PlanneUserRequest;
use Intervention\Image\ImageManager;
use Intervention\Image\Facades\Image;
use Intervention\Image\Drivers\Gd\Driver;

class PlanneController extends Controller
{
    // عرض كل الخطط
    public function allPlans()
    {
        $values = Planne::latest()->get();
        return view('admin.planne.all_planne', compact('values'));
    }



    public function allUserPlans()
    {

        $values = PlanneUserRequest::latest()->get();

        return view('admin.planne.all_planne_user_request',compact('values'));
        // return view('admin.planne.all_planne', compact('values'));
    }
    // صفحة إضافة خطة جديدة
    public function addPlan()
    {
        return view('admin.planne.add_planne');
    }

    // تخزين خطة جديدة
    public function storePlan(Request $request)
    {
     $request->validate([
    'title'       => 'required|string|max:255',
    'title_en'    => 'required|string|max:255',
    'des'         => 'required|string',
    'des_en'      => 'required|string',
    'service'     => 'required|string',
    'service_en'  => 'required|string',
    'hint'        => 'nullable|string',
    'hint_en'     => 'nullable|string',
    'price'       => 'required|numeric',
], [
    'title.required'      => '⚠️ الرجاء ادخال العنوان بالعربية',
    'title.string'        => '⚠️ العنوان بالعربية يجب أن يكون نصًا صحيحًا',
    'title.max'           => '⚠️ العنوان بالعربية يجب ألا يتجاوز 255 حرفًا',

    'title_en.required'   => '⚠️ الرجاء ادخال العنوان بالإنجليزية',
    'title_en.string'     => '⚠️ العنوان بالإنجليزية يجب أن يكون نصًا صحيحًا',
    'title_en.max'        => '⚠️ العنوان بالإنجليزية يجب ألا يتجاوز 255 حرفًا',

    'des.required'        => '⚠️ الرجاء ادخال الوصف بالعربية',
    'des.string'          => '⚠️ الوصف بالعربية يجب أن يكون نصًا صحيحًا',

    'des_en.required'     => '⚠️ الرجاء ادخال الوصف بالإنجليزية',
    'des_en.string'       => '⚠️ الوصف بالإنجليزية يجب أن يكون نصًا صحيحًا',

    'service.required'    => '⚠️ الرجاء ادخال الخدمات بالعربية',
    'service.string'      => '⚠️ الخدمات بالعربية يجب أن تكون نصًا صحيحًا',

    'service_en.required' => '⚠️ الرجاء ادخال الخدمات بالإنجليزية',
    'service_en.string'   => '⚠️ الخدمات بالإنجليزية يجب أن تكون نصًا صحيحًا',

    'hint.string'         => '⚠️ الملاحظات بالعربية يجب أن تكون نصًا صحيحًا',
    'hint_en.string'      => '⚠️ الملاحظات بالإنجليزية يجب أن تكون نصًا صحيحًا',

    'price.required'      => '⚠️ الرجاء ادخال السعر',
    'price.numeric'       => '⚠️ السعر يجب أن يكون رقمًا صحيحًا أو عشريًا',
]);


        Planne::create([
            'title'      => $request->title,
            'title_en'   => $request->title_en,
            'des'        => $request->des,
            'des_en'     => $request->des_en,
            'service'    => $request->service,
            'service_en' => $request->service_en,
            'hint'       => $request->hint,
            'hint_en'    => $request->hint_en,
            'price'      => $request->price,
            'is_suggest' => $request->is_suggest,

        ]);

        $notification = [
            'message' => 'تمت الإضافة بنجاح',
            'alert-type' => 'success'
        ];

        return redirect()->route('all.plans')->with($notification);
    }

    // صفحة تعديل خطة
    public function editPlan($id)
    {
        $value = Planne::findOrFail($id);
        return view('admin.planne.edit_planne', compact('value'));
    }

    // تحديث خطة
    public function editPlanStore(Request $request)
    {
    $request->validate([
    'id'          => 'required|exists:plannes,id',
    'title'       => 'required|string|max:255',
    'title_en'    => 'required|string|max:255',
    'des'         => 'required|string',
    'des_en'      => 'required|string',
    'service'     => 'required|string',
    'service_en'  => 'required|string',
    'hint'        => 'nullable|string',
    'hint_en'     => 'nullable|string',
    'price'       => 'required|numeric',
], [
    'id.required'        => '⚠️ المعرف مطلوب',
    'id.exists'          => '⚠️ المعرف غير موجود في قاعدة البيانات',

    'title.required'      => '⚠️ الرجاء ادخال العنوان بالعربية',
    'title.string'        => '⚠️ العنوان بالعربية يجب أن يكون نصًا صحيحًا',
    'title.max'           => '⚠️ العنوان بالعربية يجب ألا يتجاوز 255 حرفًا',

    'title_en.required'   => '⚠️ الرجاء ادخال العنوان بالإنجليزية',
    'title_en.string'     => '⚠️ العنوان بالإنجليزية يجب أن يكون نصًا صحيحًا',
    'title_en.max'        => '⚠️ العنوان بالإنجليزية يجب ألا يتجاوز 255 حرفًا',

    'des.required'        => '⚠️ الرجاء ادخال الوصف بالعربية',
    'des.string'          => '⚠️ الوصف بالعربية يجب أن يكون نصًا صحيحًا',

    'des_en.required'     => '⚠️ الرجاء ادخال الوصف بالإنجليزية',
    'des_en.string'       => '⚠️ الوصف بالإنجليزية يجب أن يكون نصًا صحيحًا',

    'service.required'    => '⚠️ الرجاء ادخال الخدمات بالعربية',
    'service.string'      => '⚠️ الخدمات بالعربية يجب أن تكون نصًا صحيحًا',

    'service_en.required' => '⚠️ الرجاء ادخال الخدمات بالإنجليزية',
    'service_en.string'   => '⚠️ الخدمات بالإنجليزية يجب أن تكون نصًا صحيحًا',

    'hint.string'         => '⚠️ الملاحظات بالعربية يجب أن تكون نصًا صحيحًا',
    'hint_en.string'      => '⚠️ الملاحظات بالإنجليزية يجب أن تكون نصًا صحيحًا',

    'price.required'      => '⚠️ الرجاء ادخال السعر',
    'price.numeric'       => '⚠️ السعر يجب أن يكون رقمًا صحيحًا أو عشريًا',
]);


        $id = $request->id;

        Planne::findOrFail($id)->update([
            'title'      => $request->title,
            'title_en'   => $request->title_en,
            'des'        => $request->des,
            'des_en'     => $request->des_en,
            'service'    => $request->service,
            'service_en' => $request->service_en,
            'hint'       => $request->hint,
            'hint_en'    => $request->hint_en,
            'price'      => $request->price,
            'is_suggest' => $request->is_suggest,

        ]);

        $notification = [
            'message' => 'تم التعديل بنجاح',
            'alert-type' => 'success'
        ];

        return redirect()->route('all.plans')->with($notification);
    }

    // حذف خطة
    public function deletePlan($id)
    {
        Planne::findOrFail($id)->delete();
        $notification = [
            'message' => 'تم الحذف بنجاح',
            'alert-type' => 'success'
        ];

        return redirect()->route('all.plans')->with($notification);
    }


      public function deleteUserPlans($id)
    {
        PlanneUserRequest::findOrFail($id)->delete();
        $notification = [
            'message' => 'تم الحذف بنجاح',
            'alert-type' => 'success'
        ];

        return redirect()->route('all.user.plans')->with($notification);
    }


}
