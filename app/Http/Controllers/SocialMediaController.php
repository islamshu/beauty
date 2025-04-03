<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\GeneralInfo;

class SocialMediaController extends Controller
{
    public function index()
    {
        return view('dashboard.social_media');
    }

    public function save(Request $request)
    {
        foreach ($request->social as $key => $value) {
            $this->saveSetting('social_' . $key, $value);
        }
        
        return redirect()->back()->with('success', 'تم حفظ إعدادات وسائل التواصل الاجتماعي بنجاح');
    }
    
    protected function saveSetting($key, $value)
    {
        $setting = GeneralInfo::firstOrNew(['key' => $key]);
        $setting->value = $value;
        $setting->save();
    }
}