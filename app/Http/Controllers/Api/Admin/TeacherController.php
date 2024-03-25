<?php

namespace App\Http\Controllers\Api\Admin;

use Carbon\Carbon;
use App\Models\User;
use App\Models\Subject;
use App\Models\Teacher;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Resources\SubjectResource;
use App\Http\Resources\TeacherResource;
use App\Http\Requests\Teacher\TeacherStoreRequest;
use App\Http\Requests\Teacher\TeacherCheckInRequest;

class TeacherController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $teachers = Teacher::get();
        return response()->json(['data'=> TeacherResource::collection( $teachers ) ], 200) ;
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(TeacherStoreRequest $request)
    {
        $user=User::find($request->user_id)->update(['role_id'=>3]);

        $teacher = Teacher::withTrashed()->where('user_id', $request->user_id)->first();
        if ($teacher) {
            $teacher->restore();
            $teacher->update(['date' => Carbon::now()]);
        } else {
            $teacher = Teacher::create([
                'user_id' => $request->user_id,
                'creator_id' => auth()->user()->id,
                'date' => Carbon::now()
            ]);
        }

        return response()->json(['msg'=> $teacher->user->name .' has been promoted to teacher'], 200) ;
    }

    /**
     * Display the specified resource.
     */
    public function show(TeacherCheckInRequest $request)
    {
        $teacher = Teacher::find($request->teacher_id);
        return response()->json([
            'message'=> "Successfull",
            'data'=> new TeacherResource( $teacher )
        ]);
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
    public function destroy(TeacherCheckInRequest $request)
    {
        $teacher = Teacher::find($request->teacher_id);
        $user= $teacher->user->update(['role_id'=>5]);
        $teacher->delete();
        return response()->json(['msg'=>'Teacher unpromoted successfully'], 200) ;
    }


    /**
     * Remove the specified resource from storage.
     */
    public function getSubjects()
    {
        $teacher = Teacher::where('user_id', auth()->user()->id)->first();
        if( !$teacher ){
            return response()->json(['msg'=>'somthing went wrong plz try again later '], 404) ;
        }
        $subjects = $teacher->subjects;
        return response()->json([
            'message'=> "Successfull",
            'data'=> SubjectResource::collection( $subjects )
        ]);
    }

    

}
