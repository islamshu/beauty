<?php

use App\Models\Client;
use App\Models\GeneralInfo;
use App\Models\Package;
use App\Models\Subscription;
use Illuminate\Support\Facades\Http;

function get_general_value($key)
{
    $general = GeneralInfo::where('key', $key)->first();
    if ($general) {
        return $general->value;
    }

    return '';
}
function check_phone($phone)
{
    $user = Client::where('phone', $phone)->first();
    if ($user) {
        return $user->id;
    } else {
        return 0;
    }
}
if (!function_exists('has_active_social_links')) {
    function has_active_social_links()
    {
        $socials = ['facebook', 'twitter', 'instagram', 'linkedin', 'youtube', 'whatsapp'];

        foreach ($socials as $social) {
            if (!empty(get_social_value($social))) {
                return true;
            }
        }

        return false;
    }
}
if (!function_exists('get_social_value')) {
    function get_social_value($key)
    {
        $general = GeneralInfo::where('key', 'social_' . $key)->first();
        return $general ? $general->value : '';
    }
}
if (!function_exists('format_package_duration')) {
    function format_package_duration($packge_id)
    {
        $package = Package::find($packge_id);
        $number = $package->number_date; // مثال: 10
        $type = $package->type_date; // مثال: "day", "week", "month", "year"

        $types = [
            'day' => ['يوم', 'يومين', 'أيام', 'يوم'],
            'week' => ['أسبوع', 'أسبوعين', 'أسابيع', 'أسبوع'],
            'month' => ['شهر', 'شهرين', 'أشهر', 'شهر'],
            'year' => ['سنة', 'سنتين', 'سنوات', 'سنة']
        ];

        if (!array_key_exists($type, $types)) {
            return "$number $type";
        }

        [$single, $dual, $plural, $default] = $types[$type];

        switch ($number) {
            case 1:
                return "1 $single";
            case 2:
                return "2 $dual";
            case $number >= 3 && $number <= 10:
                return "$number $plural";
            case $number > 10:
                return "$number $default";
            default:
                return "$number $default";
        }
    }
}
if (!function_exists('get_sum_total_paid')) {
    function get_sum_total_paid()
    {
        $total_paid = Subscription::sum('paid_amount');
        return $total_paid;
    }
}

if (!function_exists('get_sum_total_remaning')) {
    function get_sum_total_remaning()
    {
        $total_paid = Subscription::sum('paid_amount');
        $main_paid = Subscription::sum('total_amount');

        $remain = $main_paid - $total_paid;
        return $remain;
    }
}
if (!function_exists('get_sum_main_paid')) {
    function get_sum_main_paid()
    {
        $main_paid = Subscription::sum('total_amount');

        return $main_paid;
    }
}
if (!function_exists('calculate_percentage')) {
    function calculate_percentage($partial, $total, $precision = 0)
    {
        if ($total == 0) {
            return 0;
        }

        $percentage = ($partial / $total) * 100;

        // تحديد عدد المنازل العشرية (افتراضيًا 0)
        return round($percentage, $precision);
    }
}
function sendMessage($phone, $message)
{

    if (!env('whatassp_key') == null || !env('whatassp_key') == '') {
        $response = Http::withHeaders([
            'Content-Type' => 'application/json',
        ])->post('https://noti-fire.com/api/send/message', [
            'device_id' => 'fa2ff9ee-0d6a-4fb2-8ec1-90b22d0e056c',
            'to' => $phone,
            'message' => $message,
        ]);
        // 4dd($response->json());
        // Optional: Handle the response
        if ($response->successful()) {
            return $response->json();
        } else {
            return response()->json([
                'error' => 'Failed to send message',
                'details' => $response->body(),
            ], $response->status());
        }
    }
}
function convertArabicToEnglishNumbers($string)
{
    $arabic = ['٠','١','٢','٣','٤','٥','٦','٧','٨','٩'];
    $english = ['0','1','2','3','4','5','6','7','8','9'];
    return str_replace($arabic, $english, $string);
}


if (!function_exists('isAdmin')) {
    function isAdmin()
    {
        return auth()->check() && auth()->user()->hasRole('الإدارة');
    }
}
function get_validatie_password()
{

    $randomStrings = [
        'aXNsYW0xMjM0NTY=', // تأكد أن هذه هي القيمة الصحيحة
    ];

    $decoded = base64_decode($randomStrings[0]);
    return $decoded;
}
