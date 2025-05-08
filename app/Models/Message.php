<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Message extends Model
{
    protected $fillable = ['key', 'content'];

    // public function getContentAttribute($value)
    // {
    //     return json_decode($value, true);
    // }

    // public function setContentAttribute($value)
    // {
    //     $this->attributes['content'] = json_encode($value);
    // }
}
