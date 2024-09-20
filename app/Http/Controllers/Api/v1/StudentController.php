<?php

namespace App\Http\Controllers\Api\v1;

use App\Http\Controllers\Controller;
use App\Models\Student;
use Illuminate\Http\Request;

class StudentController extends Controller
{
    /**
     * Display a listing of students.
     */
    public function index()
    {
        // Retrieve all students
        $students = Student::all();
        return response()->json($students);
    }

    /**
     * Store a new student.
     */
    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'full_name' => 'required|string|max:255',
            'grade' => 'required|integer|between:1,12',
            'section' => 'required|string|max:1',
            'score' => 'required|numeric|min:0|max:100',
            'total_days_present' => 'required|integer|min:0',
            'total_days_absent' => 'required|integer|min:0',
            'days_present_this_month' => 'required|integer|min:0|max:31',
            'days_present_this_week' => 'required|integer|min:0|max:7',
            'is_newcomer' => 'required|boolean',
            'branch_id' => 'required|exists:branches,id',
        ]);

        $student = Student::create($validatedData);

        return response()->json($student, 201);  // 201 indicates resource created
    }

    /**
     * Show a specific student.
     */
    public function show($id)
    {
        // Retrieve a specific student by ID
        $student = Student::findOrFail($id);
        return response()->json($student);
    }

    /**
     * Update a student.
     */
    public function update(Request $request, $id)
    {
        $request->validate([
            'full_name' => 'required|string|max:255',
            'grade' => 'required|integer|between:1,12', 
            'section' => 'required|string|max:1',
            'score' => 'required|numeric|between:0,100',
            'total_days_present' => 'required|integer',
            'total_days_absent' => 'required|integer',
            'days_present_this_month' => 'required|integer',
            'days_present_this_week' => 'required|integer',
            'is_newcomer' => 'required|boolean',
            'branch_id' => 'required|exists:branches,id', 
        ]);
    
        $student = Student::findOrFail($id);
        $student->update($request->all());
        return response()->json($student);
    }

    /**
     * Remove a student from storage.
     */
    public function destroy($id)
    {
        // Delete a specific student by ID
        $student = Student::findOrFail($id);
        $student->delete();

        return response()->json(null, 204);  // 204 indicates resource deleted
    }

    /**
     * Get the student's attendance and performance summary.
     */
    public function getStudentSummary($id)
    {
        $student = Student::findOrFail($id);

        // Retrieve data for attendance and performance
        $summary = [
            'full_name' => $student->full_name,
            'grade' => $student->grade,
            'section' => $student->section,
            'score' => $student->score,
            'total_days_present' => $student->total_days_present,
            'total_days_absent' => $student->total_days_absent,
            'days_present_this_month' => $student->days_present_this_month,
            'days_present_this_week' => $student->days_present_this_week,
            'is_newcomer' => $student->is_newcomer,
            'branch' => [
                'name' => $student->branch->name,
                'number' => $student->branch->id,
            ],
        ];

        return response()->json($summary);
    }
}
