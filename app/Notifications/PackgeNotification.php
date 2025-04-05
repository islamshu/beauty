<?php
namespace App\Notifications;

use Illuminate\Notifications\Notification;
use Illuminate\Notifications\Messages\DatabaseMessage;

class PackgeNotification extends Notification
{
    public $order;

    public function __construct($order)
    {
        $this->order = $order;
    }

    // تحديد القنوات التي سيتم من خلالها إرسال الإشعار (هنا سنستخدم قاعدة البيانات)
    public function via($notifiable)
    {
        return ['database'];
    }

    // تنسيق الإشعار لقاعدة البيانات
    public function toDatabase($notifiable)
    {
        return [
            'title' => 'لديك طلب جديد!',
            'body' => 'تم طلب حزمة جديدة من ' . $this->order->full_name,
            'url' => route('pacgkeorders.show', $this->order->id), // رابط تفاصيل الطلب
        ];
    }
}
