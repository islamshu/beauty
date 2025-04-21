<?php

namespace App\Http\Controllers;

use App\Models\Subscription;
use App\Models\SubscriptionPayment;
use Illuminate\Http\Request;

class SubscriptionPaymentController extends Controller
{
    public function store(Request $request)
    {
        $request->validate([
            'subscription_id' => 'required|exists:subscriptions,id',
            'amount' => 'required|numeric|min:0.01',
            'payment_date' => 'required|date',
            'notes' => 'nullable|string',
        ]);

        // إنشاء الدفعة
        $payment = SubscriptionPayment::create([
            'subscription_id' => $request->subscription_id,
            'amount' => $request->amount,
            'payment_method' => 'cash',
            'payment_date' => $request->payment_date,
            'notes' => $request->notes,
            'received_by' => auth()->id(),
        ]);

        // تحديث المبلغ المدفوع في الاشتراك
        $subscription = Subscription::find($request->subscription_id);
        $subscription->update([
            'paid_amount' => $subscription->paid_amount + $request->amount
        ]);
        // إرسال رسالة تأكيد
        $customerPhone = $subscription->client->phone; // Assuming the subscription has a related customer with a phone number
        $message = "عزيزي العميل، تم استلام دفعة بقيمة {$payment->amount} شيكل  بتاريخ {$payment->payment_date}. شكراً لتعاملكم معنا.";
        // استدعاء وظيفة إرسال الرسائل
        sendMessage($customerPhone, $message);

        return response()->json([
            'success' => true,
            'message' => 'تم إضافة الدفعة بنجاح',
            'payment' => $payment
        ]);
    }

    public function destroy(SubscriptionPayment $payment)
    {
        // خصم المبلغ من الاشتراك
        $subscription = $payment->subscription;
        $subscription->update([
            'paid_amount' => $subscription->paid_amount - $payment->amount
        ]);

        $payment->delete();

        return response()->json([
            'success' => true,
            'message' => 'تم حذف الدفعة بنجاح'
        ]);
    }
}