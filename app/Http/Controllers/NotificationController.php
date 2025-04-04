<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class NotificationController extends Controller
{
    public function getNotifications(Request $request)
    {
        // جلب الإشعارات للمستخدم (نفترض أن الإشعارات مخزنة في جدول Notifications)
        // قم بتعديل هذا حسب الطريقة التي تخزن بها الإشعارات في مشروعك
        $notifications = auth()->user()->unreadNotifications()->latest()->take(5)->get();

        return response()->json($notifications);
    }
    public function show($notificationId){
        $notification = auth()->user()->notifications()->find($notificationId);
       
        if ($notification) {
            // تحديث حالة الإشعار إلى "مقروء"
            $notification->markAsRead();
        }
        $url = $notification->data['url'] ?? null;
        if ($url) {
            // إعادة توجيه المستخدم إلى الرابط المحدد في الإشعار
            return redirect($url);
        }
    
        // عرض التفاصيل الخاصة بالإشعار أو الصفحة المستهدفة
    }
}
