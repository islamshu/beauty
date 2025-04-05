<?php
namespace App\Notifications;

use Illuminate\Notifications\Notification;
use Illuminate\Notifications\Messages\DatabaseMessage;

class CourceNotification extends Notification
{
    public $cource;

    public function __construct($cource)
    {
        $this->cource = $cource;
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
            'title' => 'لديك طلب دورة جديد!',
            'body' => 'تم طلب  دورة من ' . $this->cource->name,
            'url' => route('cource_order', $this->cource->id), // رابط تفاصيل الطلب
        ];
    }
}
