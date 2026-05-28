<?php

namespace App\Http\Controllers;

use App\Models\CompanyJourney;
use Illuminate\Http\Request;
use Intervention\Image\ImageManager;
use Intervention\Image\Drivers\Gd\Driver; // أو Imagick\Driver حسب السيرفر

class CompanyJourneyController extends Controller
{
    // عرض جميع الرحلات
    public function allJourney()
    {
        $values = CompanyJourney::latest()->get();
        return view('admin.company_journey.all_company_journey', compact('values'));
    }

    // صفحة الإضافة
    public function addJourney()
    {
        return view('admin.company_journey.add_company_journey');
    }

    // حفظ رحلة جديدة
    public function storeJourney(Request $request)
    {
        $request->validate([
            'title'     => 'required|string|max:255',
            'title_en'  => 'required|string|max:255',
            'des'       => 'required|string',
            'des_en'    => 'required|string',
            'start'     => 'required|string',
            'photo'     => 'required|image|mimes:jpeg,png,jpg,gif|max:2048',
        ], [
            'title.required'    => '⚠️ الرجاء اضافة العنوان بالعربية',
            'title_en.required' => '⚠️ الرجاء اضافة العنوان بالانجليزية',
            'des.required'      => '⚠️ الرجاء اضافة الوصف بالعربية',
            'des_en.required'   => '⚠️ الرجاء اضافة الوصف بالانجليزية',
            'start.required'    => '⚠️ الرجاء تحديد البداية',
            'photo.required'    => '⚠️ الرجاء اضافة صورة',
        ]);

        if ($request->hasFile('photo')) {
            $image = $request->file('photo');
            $name_gen = hexdec(uniqid()) . '.' . $image->getClientOriginalExtension();

            $path = public_path('upload/company_journey/');
            if (!file_exists($path)) {
                mkdir($path, 0777, true);
            }

            $imageManager = new ImageManager(new Driver());
            $imageResized = $imageManager->read($image);
            $imageResized->save($path . $name_gen);

            $save_url = 'upload/company_journey/' . $name_gen;
        }

        CompanyJourney::create([
            'title'     => $request->title,
            'title_en'  => $request->title_en,
            'des'       => $request->des,
            'des_en'    => $request->des_en,
            'start'     => $request->start,
            'photo'     => $save_url ?? null,
        ]);

        return redirect()->route('all.journeys')->with([
            'message' => 'تمت الإضافة بنجاح',
            'alert-type' => 'success'
        ]);
    }

    // صفحة التعديل
    public function editJourney($id)
    {
        $value = CompanyJourney::findOrFail($id);
        return view('admin.company_journey.edit_company_journey', compact('value'));
    }

    // حفظ التعديلات
    public function editJourneyStore(Request $request)
    {
        $request->validate([
            'title'     => 'required|string|max:255',
            'title_en'  => 'required|string|max:255',
            'des'       => 'required|string',
            'des_en'    => 'required|string',
            'start'     => 'required|string',
            'photo'     => 'image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        $id = $request->id;
        $old_img = $request->old_image;

        $journey = CompanyJourney::findOrFail($id);

        if ($request->file('photo')) {
            $image = $request->file('photo');
            $name_gen = hexdec(uniqid()) . '.' . $image->getClientOriginalExtension();

            $path = public_path('upload/company_journey/');

            $imageManager = new ImageManager(new Driver());
            $imageResized = $imageManager->read($image);
            $imageResized->save($path . $name_gen);

            $save_url = 'upload/company_journey/' . $name_gen;

            if ($old_img && file_exists(public_path($old_img))) {
                unlink(public_path($old_img));
            }

            $journey->update([
                'title'     => $request->title,
                'title_en'  => $request->title_en,
                'des'       => $request->des,
                'des_en'    => $request->des_en,
                'start'     => $request->start,
                'photo'     => $save_url,
            ]);
        } else {
            $journey->update([
                'title'     => $request->title,
                'title_en'  => $request->title_en,
                'des'       => $request->des,
                'des_en'    => $request->des_en,
                'start'     => $request->start,
            ]);
        }

        return redirect()->route('all.journeys')->with([
            'message' => 'تم التعديل بنجاح',
            'alert-type' => 'success'
        ]);
    }

    // حذف رحلة
    public function deleteJourney($id)
    {
        $value = CompanyJourney::findOrFail($id);

        if ($value->photo && file_exists(public_path($value->photo))) {
            unlink(public_path($value->photo));
        }

        $value->delete();

        return redirect()->route('all.journeys')->with([
            'message' => 'تم الحذف بنجاح',
            'alert-type' => 'success'
        ]);
    }

    // تعطيل
    public function journeyInactive($id)
    {
        CompanyJourney::findOrFail($id)->update(['status' => 'inactive']);
        return redirect()->back()->with([
            'message' => 'تم التعطيل',
            'alert-type' => 'success'
        ]);
    }

    // تفعيل
    public function journeyActive($id)
    {
        CompanyJourney::findOrFail($id)->update(['status' => 'active']);
        return redirect()->back()->with([
            'message' => 'تم التفعيل',
            'alert-type' => 'success'
        ]);
    }
}
