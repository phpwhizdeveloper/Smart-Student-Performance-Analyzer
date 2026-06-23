<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Mark; // Ensure you have created a Mark model and corresponding table
use Illuminate\Http\JsonResponse;

class MarksController extends Controller
{

        public function index() 
    { 
        return view('marks'); 
    } 


public function store(Request $request): JsonResponse 
{ 
    $validatedData = $request->validate([ 
        'student_id' => 'required|integer|exists:students,id', 
        'subject_id' => 'required|integer|exists:subjects,id', // Changed from subject to subject_id
        'marks'      => 'required|integer|between:0,100', 
    ], [ 
        'student_id.exists' => 'The selected student ID is invalid.', 
        'subject_id.exists' => 'The selected subject ID is invalid.', 
        'marks.between'     => 'The marks must be between 0 and 100.', 
    ]); 

    try { 
        $markData = [
            'student_id'     => $validatedData['student_id'],
            'subject_id'     => $validatedData['subject_id'],
            'marks_obtained' => $validatedData['marks'],
        ];

        Mark::create($markData); 
        
        return response()->json([ 
            'success' => 'Student marks saved successfully!' 
        ], 201); 
        
    } catch (\Exception $e) { 
        logger()->error('Failed to save student marks: ' . $e->getMessage()); 
        
        return response()->json([ 
            'message' => 'An unexpected database error occurred.' 
        ], 500); 
    } 
}


}
