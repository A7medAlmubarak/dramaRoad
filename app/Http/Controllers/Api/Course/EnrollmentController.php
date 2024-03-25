<?php

namespace App\Http\Controllers\Api\Course;

use App\Models\Enroll;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Resources\CourseResource;

class EnrollmentController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $myCourses = Enroll::where('user_id', auth()->user()->id)
        ->join('courses', 'enroll.course_id', '=', 'courses.id')
        ->select('courses.*')
        ->get();
        return response()->json(['data'=> CourseResource::collection($myCourses) ], 200) ;
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
