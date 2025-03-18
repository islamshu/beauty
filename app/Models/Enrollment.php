<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Enrollment extends Model
{
    protected $guarded =[];
    protected $fillable = ['course_id', 'name', 'phone', 'address'];

    public function course()
    {
        return $this->belongsTo(Course::class);
    }
}
