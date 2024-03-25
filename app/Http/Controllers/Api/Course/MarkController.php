<?php

namespace App\Http\Controllers\Api\Course;

use Carbon\Carbon;
use App\Models\Mark;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Resources\MarkResource;
use App\Http\Requests\Mark\MarkStoreRequest;
use Illuminate\Support\Facades\DB;
use Exception;

class MarkController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index($student_id)
    {
        $marks = Mark::latest()->where('student_id', $student_id )->get();
        return response()->json(['data'=> MarkResource::collection( $marks ) ], 200) ;
    }


    /**
     * Store a newly created resource in storage.
     */
    public function store(MarkStoreRequest $request)
    {
      //  DB::beginTransaction();
       // try{
            $array = $request -> json()->all();
            $itemss = $array['marks'];
            foreach ( $itemss as $i => $item ){
                $mark = Mark::create([
                    'mark' => $item['mark'],
                    'student_id' => $item['student_id'],
                    'subject_id' => $request->subject_id,
                    'date' => Carbon::now()
                  ]);
            }
          //  DB::commit();
            return response()->json(['msg'=>'marks has been stored' ], 200) ;
      /*  }
        catch(Exception $exption ){
            DB::rollBack();
            return response()->json(['msg'=>'somthing went wrong' ], 404) ;
        }*/

    }

    /**complaint
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
