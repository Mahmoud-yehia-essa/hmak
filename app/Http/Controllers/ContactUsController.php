<?php

namespace App\Http\Controllers;

use App\Models\ContactUs;
use Illuminate\Http\Request;

class ContactUsController extends Controller
{
      public function allContactUs()
    {
        $values = ContactUs::latest()->get();
        return view('admin.contact_us.all_contact_us', compact('values'));
    }


     public function deleteContactUs($id){
        $contactUs = ContactUs::findOrFail($id);

        // unlink($img );

        ContactUs::findOrFail($id)->delete();
        $notification = array(
            'message' => 'تم الحذف',
            'alert-type' => 'success'
        );
        return redirect()->route('all.contact.us')->with($notification);

        // return redirect()->back()->with($notification);
    }// End Method
}
