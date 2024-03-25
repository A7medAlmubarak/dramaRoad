<?php

namespace App\Http\Controllers\Api\Post\Comment;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\AdvertisementComment;
use App\Http\Resources\CommentResource;
use App\Http\Requests\Post\CommentRequest;
use Carbon\Carbon;

class AdvertisementCommentController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index($ad_id)
    {
        $comments = AdvertisementComment::where('advertisement_id' , $ad_id  )->orderBy('created_at', 'asc')->get();
        return response()->json(['data'=> CommentResource::collection($comments) ], 200) ;
    }


    /**
     * Store a newly created resource in storage.
     */
    public function store(CommentRequest $request , $ad_id)
    {
        $inputs = $request->all();
        $inputs['user_id'] = auth()->user()->id;
        $inputs['advertisement_id'] = $ad_id;
        $inputs['date'] = Carbon::now();
        $comment = AdvertisementComment::create($inputs);
        return response()->json(['msg'=>'comment has been added'], 200) ;

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
