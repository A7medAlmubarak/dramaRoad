<?php

namespace App\Http\Controllers\Api\Course;

use App\Models\Level;
use App\Models\Course;
use App\Models\Subject;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Resources\SubjectResource;
use App\Http\Requests\Level\LevelCheckInRequest;
use App\Http\Requests\Subject\SubjectStoreRequest;
use App\Http\Requests\Subject\SubjectUpdateRequest;
use App\Http\Requests\Subject\SubjectCheckInRequest;

class SubjectController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(LevelCheckInRequest $request)
    {
        $level = Level::find( $request->level_id );
        $subjects = $level->subjects;
        return response()->json([
            'message'=> "Successfull",
            'data'=> SubjectResource::collection( $subjects ) 
        ]);    
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(SubjectStoreRequest $request)
    {
        $newSubject = Subject::create( $request->all() );
        return response()->json(['msg'=>'Subject has been added'], 200);
    }

    /**
     * Display the specified resource.
     */
    public function show(SubjectCheckInRequest $request)
    {
        $subject = Subject::find($request->subject_id);        
        return response()->json([
            'message'=> "Successfull",
            'data'=> new SubjectResource( $subject ) 
        ]);     
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(SubjectUpdateRequest $request)
    {
        $subject = Subject::find($request->subject_id);
        $updatedSubject = $subject->update($request->all());
        return response()->json(['msg'=>'subject has been updated'], 200) ;
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(SubjectCheckInRequest $request)
    {
        $subject = Subject::find($request->subject_id)->delete();
        return response()->json(['msg'=>'subject has been deleted'], 200) ;
    }
}
