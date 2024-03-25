<?php

namespace App\Http\Controllers\Api\Admin;

use Carbon\Carbon;
use App\Models\User;
use App\Models\Moderator;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Requests\Moderator\ModeratorCheckInRequest;
use App\Http\Resources\ModeratorResource;
use App\Http\Requests\Moderator\ModeratorStoreRequest;
use App\Http\Requests\Moderator\ModeratorUpdateRequest;

class ModeratorController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $mods = Moderator::get();
        return response()->json(['data'=> ModeratorResource::collection( $mods ) ], 200) ;
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(ModeratorStoreRequest $request)
    {
        $user=User::find($request->user_id)->update(['role_id'=>2]);

        $moderator = Moderator::withTrashed()->where('user_id', $request->user_id)->first();
        if ($moderator) {
            $moderator->restore();
            $moderator->update(['date' => Carbon::now()]);
        } else {
            $moderator = Moderator::create([
                'user_id' => $request->user_id,
                'employment_date' => Carbon::now()
            ]);
        }

        return response()->json(['msg'=>$moderator->user->name .' has been promoted to moderator'], 200) ;
    }

    /**
     * Display the specified resource.
     */
    public function show(ModeratorCheckInRequest $request)
    {
        $mod = Moderator::find($request->moderator_id);
        return response()->json([
            'message'=> "Successfull",
            'data'=>  new ModeratorResource( $mod )
        ]);
    }


    /**
     * Update the specified resource in storage.
     */
    public function update(ModeratorUpdateRequest $request)
    {
        $mod = Moderator::find($request->moderator_id);
        $updatedmod = $mod->update($request->all());
        return response()->json(['msg'=>'Moderator has been updated'], 200) ;
    }



    /**
     * Remove the specified resource from storage.
     */
    public function destroy(ModeratorCheckInRequest $request)
    {
        $mod = Moderator::find($request->moderator_id);
        $user= $mod->user->update(['role_id'=>5]);
        $mod->delete();
        return response()->json(['msg'=>'Moderator unpromoted successfully'], 200) ;
    }
}
