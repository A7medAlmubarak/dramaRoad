<?php

namespace App\Http\Controllers\Api\Post;

use Carbon\Carbon;
use App\Models\Poll;
use App\Models\PollLike;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Resources\PollResource;
use App\Http\Requests\Post\PollRequest;
use Illuminate\Support\Facades\Storage;

class PollController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $polls = Poll::latest()->orderBy('created_at', 'desc')->get();
        return response()->json(['data'=> PollResource::collection($polls) ], 200) ;

    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(PollRequest $request)
    {
        $inputs = $request->all();

        $inputs['date'] = Carbon::now() ;
        if ($request->hasFile('photo')) {
        $file = $request->file('photo');
        $filename = date('YmdHis') . '_' . rand(1, 10000). '_' . $file->getClientOriginalName();
        $filePath = $file->storeAs('public/Poll', $filename);
        $inputs['photo'] = str_replace('public/', '', $filePath);
        }
        $poll = Poll::create($inputs);
        return response()->json(['msg'=>'Poll has been added'], 200) ;
    }


    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $poll_id)
    {
        $poll = Poll::find($poll_id);
        if( !$poll ){
            return response()->json(['msg'=>'poll not found'], 404) ;
        }
        $poll->delete();
        return response()->json(['msg'=>'poll has been deleted'], 200) ;

    }

    public function like(string $poll_id)
    {
        $poll = Poll::find($poll_id);
        if( !$poll ){
            return response()->json(['msg'=>'poll not found'], 404) ;
        }

        $existingReaction = PollLike::where('poll_id', $poll_id)->where('user_id', auth()->id())->first();

        if ($existingReaction) {
            // User has already reacted to the poll, update the reaction
            $existingReaction->update(['like_status' => true]);
        } else {
            // User has not reacted to the poll, create a new like
            PollLike::create([
                'poll_id' => $poll_id,
                'user_id' => auth()->id(),
                'like_status' => true,
                'date' => Carbon::now()
            ]);
        }
        return response()->json(['msg'=>'poll has been liked'], 200) ;
    }

    public function dislike(string $poll_id)
    {
        $poll = Poll::find($poll_id);
        if( !$poll ){
            return response()->json(['msg'=>'poll not found'], 404) ;
        }

        $existingReaction = PollLike::where('poll_id', $poll_id)->where('user_id', auth()->id())->first();

        if ($existingReaction) {
            // User has already reacted to the poll, update the reaction
            $existingReaction->update(['like_status' => false]);
        } else {
            // User has not reacted to the poll, create a new like
            PollLike::create([
                'poll_id' => $poll_id,
                'user_id' => auth()->id(),
                'like_status' => false,
                'date' => Carbon::now()
            ]);
        }
        return response()->json(['msg'=>'poll has been disliked'], 200) ;
    }

}
