<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreReservationRequest extends FormRequest
{
    public function authorize()
    {
        return true; // تغيير إلى true للسماح بالوصول
    }

    public function rules()
    {
        return [
            'title' => 'required|string|max:255',
            'start' => 'required|date',
            'end' => 'required|date|after:start',
            'nots' => 'nullable|string',
            'client_id' => 'required|exists:clients,id',
            'user_id' => 'required|exists:users,id',
            'reason' => 'nullable|string',
            'services' => 'nullable|array', // تأكد من أن services هي مصفوفة
            'services.*' => 'exists:services,id', // تأكد من أن كل service_id موجود في جدول services
        ];
    }

    public function messages()
    {
        return [
            'title.required' => 'حقل العنوان مطلوب.',
            'start.required' => 'حقل تاريخ البداية مطلوب.',
            'end.required' => 'حقل تاريخ النهاية مطلوب.',
            'end.after' => 'تاريخ النهاية يجب أن يكون بعد تاريخ البداية.',
            'client_id.required' => 'حقل العميل مطلوب.',
            'user_id.required' => 'حقل المستخدم مطلوب.',
            'phone_number.required' => 'حقل رقم الهاتف مطلوب.',
        ];
    }
}
