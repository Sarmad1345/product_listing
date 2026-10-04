<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\Course;

class Student extends Model
{
    protected $fillable = [
        'name',
    ];

    public function courses()
    {
        return $this->belongsToMany(Course::class);
    }
}
