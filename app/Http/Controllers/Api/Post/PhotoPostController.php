<?php

namespace App\Http\Controllers\Api\Post;

use Carbon\Carbon;
use App\Models\PhotoPost;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Storage;
use App\Http\Resources\PhotoPostResource;
use App\Http\Requests\Post\PhotoPostRequest;

class PhotoPostController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $photoPosts = PhotoPost::latest()->orderBy('created_at', 'desc')->get();
        return response()->json(['data'=> PhotoPostResource::collection($photoPosts) ], 200) ;
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(PhotoPostRequest $request)
    {
        $inputs = $request->all();
        $inputs['date'] = Carbon::now() ;
        if ($request->hasFile('photo')) {
        $file = $request->file('photo');
        $filename = date('YmdHis') . '_' . rand(1, 10000). '_' . $file->getClientOriginalName();
        $filePath = $file->storeAs('public/photoPost', $filename);
        $inputs['photo'] = str_replace('public/', '', $filePath);
        }
        
        $photoPost = PhotoPost::create($inputs);
        return response()->json(['msg'=>'photo has been added'], 200) ;

    }
    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $photoPost_id)
    {
        $photoPost = PhotoPost::find($photoPost_id);
        if( !$photoPost ){
            return response()->json(['msg'=>'Photo not found'], 404) ;
        }
        $photoPost->delete();
        return response()->json(['msg'=>'Photo has been deleted'], 200) ;

    }
}
