<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use app\Models\Student;
use app\Models\Subject;

class Mark extends Model
{
        protected $table = 'marks';
    public $incrementing = true;
    protected $fillable = [
        'student_id',
        'subject_id',
        'marks_obtained',
    ];
       public function student()
    {
        return $this->belongsTo(Student::class);
    }
        public function subject()
    {
        return $this->belongsTo(Subject::class);
    }
}
