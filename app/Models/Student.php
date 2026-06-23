<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use app\Models\Subject;
use app\Models\Mark;

class Student extends Model
{
    protected $fillable = [
        'name',
        'email',
        'enrollment_number',
    ];

    
        public function subjects()
    {
        return $this->belongsToMany(Subject::class, 'marks')
                    ->withPivot('id', 'marks_obtained')
                    ->withTimestamps();
    }
        public function marks()
    {
        return $this->hasMany(Mark::class);
    }
}
