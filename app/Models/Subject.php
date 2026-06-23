<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use app\Models\Student;
use app\Models\Mark;

class Subject extends Model
{
        protected $fillable = [
        'name',
        'subject_code',
    ];

     public function students()
    {
        return $this->belongsToMany(Student::class, 'marks')
                    ->withPivot('id', 'marks_obtained')
                    ->withTimestamps();
    }

       public function marks()
    {
        return $this->hasMany(Mark::class);
    }
}
