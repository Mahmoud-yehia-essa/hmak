<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\UserServicePayment;

class UserServicePaymentController extends Controller
{
    public function updatePaymentStatus(Request $request)
    {
        $request->validate([
            'id' => 'required|exists:user_service_payments,id',
            'status' => 'required|string'
        ]);

        $payment = UserServicePayment::findOrFail($request->id);
        $payment->status = $request->status; // عادةً 'paid'
        $payment->save();

        return redirect()->back()->with('success', 'تم تحديث حالة الدفع بنجاح');
    }
}

