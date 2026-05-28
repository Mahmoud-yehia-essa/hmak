<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Service;
use App\Models\userService;
use Illuminate\Http\Request;
use App\Models\ServiceComment;
use App\Models\UserServicePayment;
use Illuminate\Support\Facades\Auth;

class UserServiceController extends Controller
{





    // allChatAdminMessage


    public function addChatAdminMessageStore(Request $request)
{

// return $request;
$user = Auth::user(); // the logged-in user object
$userId = $user->id;  // user's ID
    $request->validate([


        'comment' => 'required|string',


    ], [


        'comment.required' => 'الرجاء كتابة الرسالة.',
        'comment.string' => 'الرجاء كتابة الرسالة.',

    ]);

     $fileNamePath = "non";

    ServiceComment::create([

        'comment'=>$request->comment,
        'user_id' => $userId,
        'service_id' => $request->service_id,
         'attach_file' => $fileNamePath,



    ]);

       return redirect()->back()
                     ->with('success', 'تم ارسال رسالتك بنجاح شكرا لك');


}



     public function allChatAdminMessage($id)
    {




                $service_id = $id;
                // $user = Auth::user(); // the logged-in user object
                // $user_id = $user->id;


                   $service =  userService::find($service_id);




            $serviceComments = ServiceComment::where('service_id', $service_id)->get();

            // return  $serviceComments;


            return view('admin.user_service.chat_user_service',compact('serviceComments','service'));


        // return view('frontend.pages.user.chat_dashboard',compact('home','service_id','serviceComments','service'));
    }




    /// Chat with Ajex //



public function fetchUserMessages($service_id)
{
    $messages = ServiceComment::with('user')
        ->where('service_id', $service_id)
        ->orderBy('id', 'ASC')  // oldest first
        ->get();

    return response()->json($messages);
}


public function addUserMessagesAjax(Request $request)
{
    $user = Auth::user();

    $request->validate([
        'comment' => 'required|string',
        'service_id' => 'required|integer',
    ]);

    $message = ServiceComment::create([
        'comment' => $request->comment,
        'user_id' => $user->id,
        'service_id' => $request->service_id,
        'attach_file' => 'non',
    ]);

    // Make sure user relationship is loaded
    $message->load('user');

    return response()->json($message);
}




    //////////End Chat with ajex//////

    // عرض كل الخدمات
    public function allUserServices()
    {
        // $values = UserService::with(['user', 'service', 'payments'])->get();

        $values = userService::latest('id')->with(['user', 'service', 'payments'])->get();

        return view('admin.user_service.all_user_service', compact('values'));
    }

    // صفحة إضافة خدمة جديدة
    public function addUserService()
    {
        $users = User::all();
        $services = Service::all();
        return view('admin.user_service.add_user_service', compact('users','services'));
    }

    // حفظ خدمة جديدة
    public function storeUserService(Request $request)
    {
        $request->validate([
            'user_id'=>'required|exists:users,id',
            'service_id'=>'required|exists:services,id',
            'status'=>'required|string',
            'num_payments'=>'required|integer|min:1',
            // 'total_price'=>'required|numeric|min:0',
            'total_price' => 'nullable|numeric|min:0',

        ]);

        $userService = new userService();
        $userService->user_id = $request->user_id;
        $userService->service_id = $request->service_id;
        $userService->status = $request->status;
        $userService->des = $request->des;
        $userService->des_en = $request->des_en;
        $userService->total_price = $request->total_price;
        $userService->num_payments = $request->num_payments;

        // رفع ملف المستخدم
        if ($request->hasFile('attach')) {
            $file = $request->file('attach');
            $filename = time().'_'.$file->getClientOriginalName();
            $file->move(public_path('user_services'), $filename);
            $userService->attach = 'user_services/'.$filename;
        }

        // رفع الملف النهائي من قبل Admin
        if ($request->hasFile('admin_attach')) {
            $file = $request->file('admin_attach');
            $filename = time().'_'.$file->getClientOriginalName();
            $file->move(public_path('user_services'), $filename);
            $userService->admin_attach = 'user_services/'.$filename;
        }

        $userService->save();

        // إنشاء الدفعات تلقائياً
        $this->createPayments($userService);

        return redirect()->route('all.user_services')->with('success', 'تم إضافة الخدمة بنجاح');
    }

    // صفحة تعديل خدمة
    public function editUserService($id)
    {
        $value = userService::with('payments')->findOrFail($id);
        $users = User::all();
        $services = Service::all();
        return view('admin.user_service.edit_user_service', compact('value','users','services'));
    }

    // تحديث الخدمة
    public function updateUserService(Request $request)
    {
        $request->validate([
            'id'=>'required|exists:user_services,id',
            'user_id'=>'required|exists:users,id',
            'service_id'=>'required|exists:services,id',
            'status'=>'required|string',
            // 'num_payments'=>'required|integer|min:1',
            'total_price'=>'required|numeric|min:0',
        ]);

        $userService = userService::findOrFail($request->id);
        $userService->user_id = $request->user_id;
        $userService->service_id = $request->service_id;
        $userService->status = $request->status;
        $userService->des = $request->des;
        $userService->des_en = $request->des_en;
        $userService->total_price = $request->total_price;
        $userService->num_payments = $request->num_payments;

        // رفع ملف المستخدم إذا تم تغييره
        if ($request->hasFile('attach')) {
            $file = $request->file('attach');
            $filename = time().'_'.$file->getClientOriginalName();
            $file->move(public_path('user_services'), $filename);
            $userService->attach = 'user_services/'.$filename;
        }

        // رفع الملف النهائي Admin إذا تم تغييره
        if ($request->hasFile('admin_attach')) {
            $file = $request->file('admin_attach');
            $filename = time().'_'.$file->getClientOriginalName();
            $file->move(public_path('user_services'), $filename);
            $userService->admin_attach = 'user_services/'.$filename;
        }

        $userService->save();

        // إعادة إنشاء الدفعات إذا تغير عدد الدفعات
        if($userService->payments()->count() != $request->num_payments){
            $userService->payments()->delete();
            $this->createPayments($userService);
        }

        return redirect()->route('all.user_services')->with('success', 'تم تحديث الخدمة بنجاح');
    }

    // حذف خدمة
    public function deleteUserService($id)
    {
        $userService = userService::findOrFail($id);
        $userService->payments()->delete();
        $userService->delete();
        return redirect()->back()->with('success', 'تم حذف الخدمة بنجاح');
    }

    // إنشاء الدفعات تلقائياً
    private function createPayments(userService $userService)
    {
        $total = $userService->total_price;
        $num = $userService->num_payments;
        $amount = $total / $num;

        for($i=1;$i<=$num;$i++){
            UserServicePayment::create([
                'user_service_id' => $userService->id,
                'payment_number' => $i,
                'amount' => $amount,
                'status' => 'pending',
            ]);
        }
    }

    // تحديث حالة الدفع (من pending إلى paid)
    public function updatePaymentStatus(Request $request)
    {
        $request->validate([
            'id' => 'required|exists:user_service_payments,id',
            'status' => 'required|string'
        ]);

        $payment = UserServicePayment::findOrFail($request->id);
        $payment->update([
            'status' => $request->status
        ]);

        return back()->with('success', 'تم تحديث حالة الدفع بنجاح');
    }
}
