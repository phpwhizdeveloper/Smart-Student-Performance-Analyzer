<?php

namespace App\Http\Controllers;

use App\Services\PerformanceAnalysisService;
use App\Models\Student;
use Illuminate\Http\Request;
use App\Models\Mark;

class PerformanceController extends Controller
{
    protected $performanceService;

    public function __construct(PerformanceAnalysisService $performanceService)
    {
        $this->performanceService = $performanceService;
    }

    public function searchStudents(Request $request)
    {
        $query = $request->input('query');
        
        $students = Student::where('name', 'LIKE', "%{$query}%")
                    ->orWhere('student_id_number', 'LIKE', "%{$query}%")
                    ->get();

        return response()->json($students);
    }

    public function generateReport($studentId)
    {
        $rankings = $this->performanceService->calculateStudentAverages();
        $studentReport = $rankings->firstWhere('id', $studentId);
        $weakSubjectAnalysis = $this->performanceService->analyzeWeakSubjects($studentId);
        $englishSummary = $this->performanceService->generateEnglishSummary($studentId);

        return response()->json([
            'report' => $studentReport,
            'weak_subjects' => $weakSubjectAnalysis,
            'english_summary' => $englishSummary
        ]);
    }

public function showStudentDetail($studentId)
{
    $rankings = $this->performanceService->calculateStudentAverages();
    $studentReport = $rankings->firstWhere('id', $studentId);

    if (!$studentReport) {
        abort(404, 'Student performance records not found.');
    }

    $weakSubjectAnalysis = $this->performanceService->analyzeWeakSubjects($studentId); 

    $groupedAnalysis = collect($weakSubjectAnalysis)
        ->groupBy('student_id')
        ->map(function ($group) {
            return [
                'student_id' => $group->first()['subject'], // Or dynamically get the key you need
                'marks' => round($group->avg('marks')),
                'class_average' => 0,
            ];
        })
        ->values();


    $englishSummary = $this->performanceService->generateEnglishSummary($studentId);
    $studentMarks = Mark::where('student_id', $studentId)->get();
    $studentAverage = $studentMarks->avg('marks_obtained');

    return view('detail', compact('studentReport', 'groupedAnalysis', 'englishSummary', 'studentMarks', 'studentAverage'));
}

}
