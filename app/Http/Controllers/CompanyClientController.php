<?php

namespace App\Http\Controllers;

use App\Models\CompanyClient;
use Illuminate\Http\Request;
use Intervention\Image\ImageManager;

use Intervention\Image\Facades\Image;
use Intervention\Image\Drivers\Gd\Driver;
class CompanyClientController extends Controller
{
    // عرض كل العملاء
    public function allCompanyClients()
    {
        $values = CompanyClient::latest()->get();
        return view('admin.company_client.all_company_client', compact('values'));
    }

    // صفحة إضافة عميل جديد
    public function addCompanyClient()
    {
        return view('admin.company_client.add_company_client');
    }

    // تخزين عميل جديد
    public function storeCompanyClient(Request $request)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'title_en' => 'required|string|max:255',
            'des' => 'nullable|string',
            'des_en' => 'nullable|string',
            'photo' => 'nullable|image|mimes:jpg,jpeg,png|max:2048',
        ]);

        $save_url = null;
        if ($request->file('photo')) {
            $file = $request->file('photo');
            $filename = date('YmdHi') . '_' . $file->getClientOriginalName();
            $file->move(public_path('upload/company_client/'), $filename);
            $save_url = 'upload/company_client/' . $filename;
        }

        CompanyClient::create([
            'title' => $request->title,
            'title_en' => $request->title_en,
            'des' => $request->des,
            'des_en' => $request->des_en,
            'photo' => $save_url,
            'status' => 'active',
        ]);

        return redirect()->route('all.company_clients')->with('success', 'تمت إضافة العميل بنجاح');
    }

    // صفحة تعديل العميل
    public function editCompanyClient($id)
    {
        $value = CompanyClient::findOrFail($id);
        return view('admin.company_client.edit_company_client', compact('value'));
    }

    // تحديث العميل
    public function editCompanyClientStore(Request $request)
    {
        $request->validate([
            'id' => 'required|exists:company_clients,id',
            'title' => 'required|string|max:255',
            'title_en' => 'required|string|max:255',
            'des' => 'nullable|string',
            'des_en' => 'nullable|string',
            'photo' => 'nullable|image|mimes:jpg,jpeg,png|max:2048',
        ]);

        $client = CompanyClient::findOrFail($request->id);

        $save_url = $client->photo;
        if ($request->file('photo')) {
            if ($client->photo && file_exists(public_path($client->photo))) {
                unlink(public_path($client->photo));
            }
            $file = $request->file('photo');
            $filename = date('YmdHi') . '_' . $file->getClientOriginalName();
            $file->move(public_path('upload/company_client/'), $filename);
            $save_url = 'upload/company_client/' . $filename;
        }

        $client->update([
            'title' => $request->title,
            'title_en' => $request->title_en,
            'des' => $request->des,
            'des_en' => $request->des_en,
            'photo' => $save_url,
        ]);

        return redirect()->route('all.company_clients')->with('success', 'تم تعديل بيانات العميل بنجاح');
    }

    // حذف العميل
    public function deleteCompanyClient($id)
    {
        $client = CompanyClient::findOrFail($id);
        if ($client->photo && file_exists(public_path($client->photo))) {
            unlink(public_path($client->photo));
        }
        $client->delete();

        return redirect()->route('all.company_clients')->with('success', 'تم حذف العميل بنجاح');
    }

    // جعل العميل غير نشط
    public function clientInactive($id)
    {
        CompanyClient::findOrFail($id)->update(['status' => 'inactive']);
        return redirect()->route('all.company_clients')->with('success', 'تم إخفاء العميل');
    }

    // جعل العميل نشط
    public function clientActive($id)
    {
        CompanyClient::findOrFail($id)->update(['status' => 'active']);
        return redirect()->route('all.company_clients')->with('success', 'تم إظهار العميل');
    }
}
