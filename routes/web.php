<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\StudentController;
use App\Http\Controllers\MarksController;
use App\Http\Controllers\PerformanceController;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/students/create', [StudentController::class, 'index'])->name('students.index');
Route::get('/marks/create', [MarksController::class, 'index'])->name('marks.index');

// Direct Storage Web Routes 
Route::post('/students', [StudentController::class, 'storeStudent'])->name('students.store');
Route::post('/marks', [MarksController::class, 'store']);

Route::get('/show_student_detail/{id}', [PerformanceController::class, 'showStudentDetail'])->name('student.detail');
