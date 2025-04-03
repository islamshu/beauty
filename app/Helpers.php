<?php

use App\Models\Client;
use App\Models\GeneralInfo;

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
