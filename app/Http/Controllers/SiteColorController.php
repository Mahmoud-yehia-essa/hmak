<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\SiteColor;

class SiteColorController extends Controller
{
    // عرض الألوان (صفحة الإعدادات)
    public function index()
    {
        $color = SiteColor::first(); // نجيب أول سجل فقط
        return view('admin.site_colors.index', compact('color'));
    }

    // تحديث الألوان
    public function update(Request $request)
    {
        $request->validate([
            'primary_color'   => 'nullable|string',
            'secondary_color' => 'nullable|string',
            'font_color'      => 'nullable|string',

                'font_color_main_header_home' => 'nullable|string',
            'font_color_normal_header_home' => 'nullable|string',
            'font_color_main_home' => 'nullable|string',
            'font_color_normal_home' => 'nullable|string',

        ]);

        $color = SiteColor::first();
        if (!$color) {
            $color = new SiteColor();
        }

        $color->primary_color   = $request->primary_color;
        $color->secondary_color = $request->secondary_color;
        $color->font_color      = $request->font_color;





        $color->font_color_main_header_home      = $request->font_color_main_header_home;
        $color->font_color_normal_header_home      = $request->font_color_normal_header_home;

        $color->font_color_main_home      = $request->font_color_main_home;
        $color->font_color_normal_home      = $request->font_color_normal_home;


        $color->save();

             $notification = array(
            'message' => 'تم تعديل الألوان',
            'alert-type' => 'success'
        );
        return redirect()->route('site.colors')->with($notification);


    }
}
