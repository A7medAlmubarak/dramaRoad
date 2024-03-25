<?php

namespace App\Http\Controllers\Api\Course;

use Carbon\Carbon;
use App\Models\Course;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Resources\CourseResource;
use App\Http\Requests\Course\CourseStoreRequest;
use App\Http\Requests\Course\CourseUpdateRequest;
use App\Http\Requests\Course\CourseCheckInRequest;

class CourseController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function getAllPublishedCourses()
    {
        $courses = Course::latest()->get();
        return response()->json(['data'=> CourseResource::collection( $courses ) ], 200) ;
    }

    public function getAllActiveCourses()
    {
        $courses = Course::latest()->where('registration_end_date','<', Carbon::today() )->where('finished_status',false  )->get();
        return response()->json(['data'=> CourseResource::collection( $courses ) ], 200) ;
    }

    public function getAllClosedCourses()
    {
        $courses = Course::latest()->where('finished_status',true)->get();
        return response()->json(['data'=> CourseResource::collection( $courses ) ], 200) ;
    }



    /**
     * Store a newly created resource in storage.
     */
    public function store(CourseStoreRequest $request)
    {
        $inputs = $request->all();
        $inputs['creator_id'] = auth()->user()->id;
        $course = Course::create($inputs);
        return response()->json(['msg'=>'course has been added'], 200) ;
    }

    /**
     * Display the specified resource.
     */
    public function show(CourseCheckInRequest $request)
    {
        $course = Course::find($request->course_id);
        return response()->json([
            'message'=> "Successfull",
            'data'=> new CourseResource( $course )
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(CourseUpdateRequest $request)
    {
        $course = Course::find($request->course_id);
        $updatedcourse = $course->update($request->all());
        return response()->json(['msg'=>'course has been updated'], 200) ;
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(CourseCheckInRequest $request)
    {
        $course = Course::find($request->course_id)->delete();
        return response()->json(['msg'=>'course has been deleted'], 200) ;
    }

    public function publish(CourseCheckInRequest $request)
    {
        $course = Course::find($request->course_id);
        if( $course->publish_status ){
            return response()->json(['msg'=>'course is already published'], 200) ;
        }
        $course->publish_status = true;
        $course->save();
        return response()->json(['msg'=>'course has been published'], 200) ;
    }

}
