<?php

namespace App\Http\Controllers;

use App\Models\TeamWork;
use Illuminate\Http\Request;
use Intervention\Image\ImageManager;
use Intervention\Image\Facades\Image;
use Intervention\Image\Drivers\Gd\Driver;

class TeamWorkController extends Controller
{
    // ✅ عرض كل أعضاء الفريق
    public function allTeamworks()
    {
        $values = TeamWork::latest()->get();
        return view('admin.team_work.all_team_work', compact('values'));
    }

    // ✅ صفحة إضافة عضو جديد
    public function addTeamwork()
    {
        return view('admin.team_work.add_team_work');
    }

    // ✅ تخزين عضو جديد
    public function storeTeamwork(Request $request)
    {
        $request->validate([
            'name'      => 'required|string|max:255',
            'name_en'   => 'required|string|max:255',
            'position'  => 'required|string',
            'position_en' => 'required|string',
            'photo'     => 'nullable|image|mimes:jpg,jpeg,png|max:2048',
        ], [
            'name.required' => 'حقل الاسم بالعربية مطلوب',
            'name_en.required' => 'حقل الاسم بالإنجليزية مطلوب',
            'position.required' => 'حقل المنصب بالعربية مطلوب',
            'position_en.required' => 'حقل المنصب بالإنجليزية مطلوب',
            'photo.image' => 'يجب أن تكون الصورة بصيغة صحيحة',
        ]);

        $save_url = null;
        if ($request->file('photo')) {
            $file = $request->file('photo');
            $filename = date('YmdHi') . '_' . $file->getClientOriginalName();
            $file->move(public_path('upload/team_work/'), $filename);
            $save_url = 'upload/team_work/' . $filename;
        }

        TeamWork::create([
            'name'       => $request->name,
            'name_en'    => $request->name_en,
            'position'   => $request->position,
            'position_en'=> $request->position_en,
            'des'=> $request->des,
            'des_en'=> $request->des_en,

            'photo'      => $save_url,
            'status'     => 'active',
        ]);

        return redirect()->route('all.teamworks')->with('success', 'تمت إضافة عضو الفريق بنجاح');
    }

    // ✅ صفحة تعديل عضو
    public function editTeamwork($id)
    {
        $value = TeamWork::findOrFail($id);
        return view('admin.team_work.edit_team_work', compact('value'));
    }

    // ✅ تحديث عضو
    public function editTeamworkStore(Request $request)
    {
        $request->validate([
            'id'        => 'required|exists:team_works,id',
            'name'      => 'required|string|max:255',
            'name_en'   => 'required|string|max:255',
            'position'  => 'required|string',
            'position_en' => 'required|string',
            'photo'     => 'nullable|image|mimes:jpg,jpeg,png|max:2048',
        ], [
            'name.required' => 'حقل الاسم بالعربية مطلوب',
            'name_en.required' => 'حقل الاسم بالإنجليزية مطلوب',
            'position.required' => 'حقل المنصب بالعربية مطلوب',
            'position_en.required' => 'حقل المنصب بالإنجليزية مطلوب',
            'photo.image' => 'يجب أن تكون الصورة بصيغة صحيحة',
        ]);

        $teamwork = TeamWork::findOrFail($request->id);

        $save_url = $teamwork->photo;
        if ($request->file('photo')) {
            // حذف القديم إذا موجود
            if ($teamwork->photo && file_exists(public_path($teamwork->photo))) {
                unlink(public_path($teamwork->photo));
            }
            $file = $request->file('photo');
            $filename = date('YmdHi') . '_' . $file->getClientOriginalName();
            $file->move(public_path('upload/team_work/'), $filename);
            $save_url = 'upload/team_work/' . $filename;
        }

        $teamwork->update([
            'name'       => $request->name,
            'name_en'    => $request->name_en,
            'position'   => $request->position,
            'position_en'=> $request->position_en,
            'des'=> $request->des,
            'des_en'=> $request->des_en,
            'photo'      => $save_url,
        ]);

        return redirect()->route('all.teamworks')->with('success', 'تم تعديل بيانات عضو الفريق بنجاح');
    }

    // ✅ حذف عضو
    public function deleteTeamwork($id)
    {
        $teamwork = TeamWork::findOrFail($id);
        if ($teamwork->photo && file_exists(public_path($teamwork->photo))) {
            unlink(public_path($teamwork->photo));
        }
        $teamwork->delete();

        return redirect()->route('all.teamworks')->with('success', 'تم حذف عضو الفريق بنجاح');
    }

    // ✅ جعل العضو غير نشط
    public function teamworkInactive($id)
    {
        TeamWork::findOrFail($id)->update(['status' => 'inactive']);
        return redirect()->route('all.teamworks')->with('success', 'تم إخفاء العضو');
    }

    // ✅ جعل العضو نشط
    public function teamworkActive($id)
    {
        TeamWork::findOrFail($id)->update(['status' => 'active']);
        return redirect()->route('all.teamworks')->with('success', 'تم إظهار العضو');
    }
}
