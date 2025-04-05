<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Enrollment extends Model
{
    protected $fillable = [
    'course_id',
    'name',
    'phone',
    'whatsapp',
    'experience',
    'goal',
    'address',
    'status'
];
public function changeStatus($newStatus)
{
    $allowedStatuses = ['pending', 'approved', 'rejected'];
    
    if (in_array($newStatus, $allowedStatuses)) {
        $this->update(['status' => $newStatus]);
        return true;
    }
    
    return false;
}

    public function course()
    {
        return $this->belongsTo(Course::class);
    }
}
