<?php

namespace App\Http\Controllers\Api\Post;

use Illuminate\Http\Request;
use App\Models\Advertisement;
use App\Http\Controllers\Controller;
use App\Http\Resources\AdvertisementResource;
use App\Http\Requests\Post\AdvertisementRequest;
use Carbon\Carbon;
use Illuminate\Support\Facades\Storage;

class AdvertisementController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $ads = Advertisement::latest()->orderBy('created_at', 'desc')->get();
        return response()->json(['data'=> AdvertisementResource::collection($ads) ], 200) ;
    }


    /**
     * Store a newly created resource in storage.
     */
    public function store(AdvertisementRequest $request)
    {
        $inputs = $request->all();
        $inputs['date'] = Carbon::now() ;
        if ($request->hasFile('photo')) {
        $file = $request->file('photo');
        $filename = date('YmdHis') . '_' . rand(1, 10000). '_' . $file->getClientOriginalName();
        $filePath = $file->storeAs('public/Advertisement', $filename);
        $inputs['photo'] = str_replace('public/', '', $filePath);

        }
        $ad = Advertisement::create($inputs);
        return response()->json(['msg'=>'Advertisement has been added'], 200) ;
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $ad_id)
    {
        $add = Advertisement::find($ad_id);
        if( !$add ){
            return response()->json(['msg'=>'Advertisement not found'], 404) ;
        }
        $add->delete();
        return response()->json(['msg'=>'Advertisement has been deleted'], 200) ;

    }
}
