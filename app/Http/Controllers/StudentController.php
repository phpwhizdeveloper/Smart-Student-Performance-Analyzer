<?php 

namespace App\Http\Controllers; 

use Illuminate\Http\Request; 
use Illuminate\Support\Facades\Validator; 
use App\Models\Student; 
use App\Models\Mark; 

class StudentController extends Controller 
{ 
    // Return the main entry view 
    public function index() 
    { 
        return view('student_entry'); 
    } 

    // Store Student 
    public function storeStudent(Request $request) 
    { 
        $validator = Validator::make($request->all(), [ 
            'name' => 'required|string|max:255', 
            'email' => 'required|email|unique:students,email', 
            'enrollment_number' => 'required|string|unique:students,enrollment_number' 
        ]); 

        if ($validator->fails()) { 
            return response()->json(['errors' => $validator->errors()], 422); 
        } 

        // SAVES DIRECTLY TO DATABASE
        Student::create($request->all()); 

        return response()->json(['success' => 'Student added successfully!']); 
    } 

}
