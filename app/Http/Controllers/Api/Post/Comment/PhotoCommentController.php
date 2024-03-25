<?php

namespace App\Http\Controllers\Api\Post\Comment;

use Carbon\Carbon;
use Illuminate\Http\Request;
use App\Models\PhotoPostComment;
use App\Http\Controllers\Controller;
use App\Http\Resources\CommentResource;

class PhotoCommentController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index($photo_id)
    {
        $comments = PhotoPostComment::where('photo_post_id' , $photo_id  )->orderBy('created_at', 'asc')->get();
        return response()->json(['data'=> CommentResource::collection($comments) ], 200) ;
    }


    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request, $photo_id)
    {
        $inputs = $request->all();
        $inputs['user_id'] = auth()->user()->id;
        $inputs['photo_post_id'] = $photo_id;
        $inputs['date'] = Carbon::now();
        $comment = PhotoPostComment::create($inputs);
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
