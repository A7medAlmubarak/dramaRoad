<?php

namespace App\Http\Controllers\Api\Attendance;

use App\Models\Student;
use App\Models\Teacher;
use Illuminate\Http\Request;
use App\Models\Student_attendance;
use App\Models\Teacher_attendance;
use App\Http\Controllers\Controller;
use App\Http\Requests\Student\StudentCheckInRequest;
use Carbon\Carbon;

class AttendanceController extends Controller
{

    public function markStudentAttendance(StudentCheckInRequest $request)
    {
        $teacher = Teacher::find(auth()->user()->id); // Assuming teacher is authenticated
        $student = Student::find($request->student_id);
        $attendance = Student_attendance::create([
            'student_id' => $request->student_id,
            'date' => Carbon::today(),
            'status' => true,
        ]);

        $date = $request->date;

    }

    /**
     * Display a listing of the resource.
     */
    public function index2()
    {
        //
    }

    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
