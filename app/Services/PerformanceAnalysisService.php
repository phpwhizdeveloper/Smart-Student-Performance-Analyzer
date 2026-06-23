<?php

namespace App\Services;

use App\Models\Student;
use App\Models\Mark;

class PerformanceAnalysisService
{
    public function calculateStudentAverages()
    {
        return Student::with('marks')
            ->get()
            ->map(function ($student) {
                $totalMarks = $student->marks->sum('marks_obtained');
                $count = $student->marks->count();
                $student->average = $count > 0 ? round($totalMarks / $count, 2) : 0;
                return $student;
            })
            ->sortByDesc('average')
            ->values() // Re-index after sorting
            ->map(function ($student, $index) {
                $student->rank = $index + 1; // Task 5.1
                $student->grade = $this->generateGrade($student->average);
                $student->scholarship = $this->determineScholarship($student->average); 
                return $student;
            });
    }

    public function generateGrade($average)
    {
        if ($average >= 90) return 'A+';
        if ($average >= 80) return 'A';
        if ($average >= 70) return 'B';
        if ($average >= 60) return 'C';
        if ($average >= 50) return 'D';
        return 'F';
    }

    public function determineScholarship($average)
    {
        if ($average >= 90) return 'Full Scholarship';
        if ($average >= 80) return 'Partial Scholarship';
        return 'None';
    }

    public function analyzeWeakSubjects($studentId)
    {
        $marks = Mark::where('student_id', $studentId)
            ->with('subject')
            ->get();

        return $marks->map(function ($mark) {
            $suggestions = '';
            if ($mark->marks_obtained < 50) {
                $suggestions = 'Extra tutoring recommended in ' . $mark->subject->name . '. Focus on foundational concepts.';
            }

            return [
                'subject' => $mark->subject->name,
                'marks' => $mark->marks_obtained,
                'is_weak' => $mark->marks_obtained < 50,
                'suggestion' => $suggestions
            ];
        });
    }

    public function generateEnglishSummary($studentId)
    {
        $student = Student::findOrFail($studentId);
        $averages = $this->calculateStudentAverages();
        $studentPerformance = $averages->firstWhere('id', $studentId);

        if (!$studentPerformance) {
            return "No performance data available for this student.";
        }

        $summary = "Student {$student->name} has achieved an average score of {$studentPerformance->average}%, ";
        $summary .= "securing an overall grade of '{$studentPerformance->grade}'. ";
        $summary .= "They are ranked #{$studentPerformance->rank} in the class and are eligible for '{$studentPerformance->scholarship}'.";

        return $summary;
    }
}
