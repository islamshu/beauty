<?php

use App\Models\Client;
use App\Models\GeneralInfo;
use App\Models\Package;

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
    function format_package_duration($packge_id) {
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
