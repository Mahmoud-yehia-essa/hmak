<?php

namespace App\Http\Controllers;

use App\Models\MainCounter;
use Illuminate\Http\Request;
use SebastianBergmann\LinesOfCode\Counter;

class CounterController extends Controller
{

  public function allCounter()
    {
        $counter = MainCounter::latest()->get();




        return view('admin.counter.counter_all',compact('counter'));
    }



      public function editCounter($id){



            $counter = MainCounter::findOrFail($id);

        return view('admin.counter.counter_edit',compact('counter'));
    }


    //    public function addSponsorQuestion(){

    //         $getSponsorHome = Sponsor::findOrFail(2);

    //     return view('admin.sponsor.sponsor_home_cate_add',compact('getSponsorHome'));
    // }



       public function editCounterStore(Request $request){



$request->validate([
    'title'     => 'required|string|max:255',
    'title_en'  => 'required|string|max:255',
            'counter' => 'nullable|required',




], [
    'title.required'    => '⚠️ الرجاء اضافة العنوان بالعربية',
    'title.string'      => '⚠️ الرجاء التأكد من كتابة العنوان بشكل صحيح',
    'title.max'         => '⚠️ العنوان لا يجب أن يتعدى 255 حرف',

    'title_en.required' => '⚠️ الرجاء اضافة العنوان بالانجليزية',
    'title_en.string'   => '⚠️ الرجاء التأكد من كتابة العنوان بالانجليزية بشكل صحيح',
    'title_en.max'      => '⚠️ العنوان بالانجليزية لا يجب أن يتعدى 255 حرف',

     'counter.required' => 'الرجاء ادخال الرقم.',
        'counter.integer' => 'الرجاء ادخال الرقم عددا.',

]);



$id = $request->id;

MainCounter::findOrFail($id)->update([
    'title'     => $request->title,
    'title_en'  => $request->title_en,
    'counter'       => $request->counter,

]);


       $notification = array(
            'message' => 'تم التعديل ',
            'alert-type' => 'success'
        );
        return redirect()->route('all.counter')->with($notification);

    }// End Method




      public function counterInactive($id){
        MainCounter::findOrFail($id)->update(['status' => 'inactive']);
        $notification = array(
            'message' => ' غير مفعل',
            'alert-type' => 'success'
        );
        return redirect()->back()->with($notification);
    }// End Method
      public function counterActive($id){
        MainCounter::findOrFail($id)->update(['status' => 'active']);
        $notification = array(
            'message' => 'مفعل',
            'alert-type' => 'success'
        );
        return redirect()->back()->with($notification);
    }


}
