<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Contact extends Model
{
    protected $fillable = [
        'name',       // Corresponds to 'contact-form-name'
        'email',      // Corresponds to 'contact-form-email'
        'phone',      // Corresponds to 'contact-form-mobile'
        'message',    // Corresponds to 'contact-form-message'
    ];
}
