<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Blade;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        //
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        // WhatsApp number formatter macro
        Str::macro('formatWhatsApp', function($number) {
            // Remove all non-digit characters
            $cleaned = preg_replace('/[^0-9]/', '', $number);
            
            // Handle empty input
            if (empty($cleaned)) {
                return '';
            }

            // Handle Palestinian numbers (970)
            if (Str::startsWith($cleaned, '970')) {
                return '+'.$cleaned;
            }
            
            // Handle numbers starting with 0 (assume Palestinian)
            if (Str::startsWith($cleaned, '0')) {
                return '+970'.substr($cleaned, 1);
            }
            
            // Handle numbers without country code (assume Palestinian if <= 9 digits)
            if (strlen($cleaned) <= 9) {
                return '+970'.$cleaned;
            }
            
            // For international numbers already with country code
            return '+'.$cleaned;
        });

        // Blade directive for WhatsApp links
        Blade::directive('whatsappLink', function($expression) {
            return "<?php echo 'https://wa.me/' . \\Illuminate\\Support\\Str::formatWhatsApp($expression); ?>";
        });

        // Validation rule for WhatsApp numbers
        Validator::extend('whatsapp_number', function ($attribute, $value, $parameters, $validator) {
            $cleaned = preg_replace('/[^0-9]/', '', $value);
            return strlen($cleaned) >= 9 && strlen($cleaned) <= 15;
        });

        // Validation message
        Validator::replacer('whatsapp_number', function($message, $attribute, $rule, $parameters) {
            return str_replace(':attribute', $attribute, 'The :attribute must be a valid WhatsApp number');
        });
    }
}