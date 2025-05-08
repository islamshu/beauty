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
            'nots' => 'nullable|string',
            'client_id' => 'required|exists:clients,id',
            'user_id' => 'required|exists:users,id',
            'reason' => 'nullable|string',
            'services' => 'nullable|array',
            'services.*' => 'exists:services,id',
            'start_time' => 'required|date_format:H:i',
            'end_time' => 'required|date_format:H:i|after:start_time',
        ];
    }
    
    public function messages()
    {
        return [
            'title.required' => 'حقل العنوان مطلوب.',
      
            'end.after' => 'تاريخ النهاية يجب أن يكون بعد تاريخ البداية.',
            'start_time.required' => 'حقل وقت البداية مطلوب.',
            'end_time.required' => 'حقل وقت النهاية مطلوب.',
            'end_time.after' => 'وقت النهاية يجب أن يكون بعد وقت البداية.',
            'client_id.required' => 'حقل العميل مطلوب.',
            'user_id.required' => 'حقل المستخدم مطلوب.',
        ];
    }
    
}
