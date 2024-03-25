<?php

namespace App\Http\Controllers\Api\Admin;

use Carbon\Carbon;
use App\Models\User;
use App\Models\Student;
use App\Models\Moderator;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Requests\Student\StudentCheckInRequest;
use App\Http\Resources\StudentResource;
use App\Http\Requests\Student\StudentStoreRequest;

class StudentController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $students = Student::get();
        return response()->json(['data'=> StudentResource::collection( $students ) ], 200) ;
    }

    /**
     * Store a newly created resource in storage.
     */
   /* public function store(StudentStoreRequest $request)
    {
        $user=User::find($request->user_id)->update(['role_id'=>2]);
        $student = Student::create([
            'user_id' => $request->user_id,
            'creator_id' => auth()->user()->id , 
            'date'=> Carbon::now()
        ]);
        return response()->json(['msg'=>$student->user->name .' has been promoted to moderator'], 200) ;
    }*/

    /**
     * Display the specified resource.
     */
    public function show(StudentCheckInRequest $request)
    {
        $student = Student::find($request->student_id);
        return response()->json([
            'message'=> "Successfull",
            'data'=> new StudentResource( $student ) 
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
    public function destroy(StudentCheckInRequest $request)
    {
        $student = Student::find($request->student_id);
        $user= $student->user->update(['role_id'=>5]);
        $student->delete();
        return response()->json(['msg'=>'Student unpromoted successfully'], 200) ;
    }
}
