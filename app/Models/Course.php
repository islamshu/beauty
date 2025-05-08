<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Course extends Model
{
    protected $guarded = [];
    public function category()
    {
        return $this->belongsTo(Category::class);
    }
    public function shortDescription($limit = 49)
{
    return mb_strimwidth(strip_tags($this->description), 0, $limit, '...');
}

}
