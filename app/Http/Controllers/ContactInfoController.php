<?php

namespace App\Http\Controllers;

use App\Models\ContactInfo;
use Illuminate\Http\Request;

class ContactInfoController extends Controller
{
    // عرض صفحة الاتصال
    public function index()
    {
        $contact = ContactInfo::first(); // عندنا سجل واحد فقط
        return view('admin.contact_info.index_contact_info', compact('contact'));
    }

    // تحديث بيانات الاتصال
    public function update(Request $request)
    {
        $contact = ContactInfo::first();


        if (!$contact) {
            $contact = new ContactInfo();
        }

        $contact->update($request->all());

        return redirect()->back()->with('success', 'تم تحديث معلومات الاتصال بنجاح ✅');
    }
}
