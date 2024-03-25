<?php

namespace App\Http\Controllers\Api;

use Carbon\Carbon;
use App\Models\Poll;
use App\Models\Course;
use App\Models\PhotoPost;
use Illuminate\Http\Request;
use App\Models\Advertisement;
use App\Http\Controllers\Controller;
use App\Http\Resources\PollResource;
use App\Http\Resources\CourseResource;
use App\Http\Resources\PhotoPostResource;
use App\Http\Resources\AdvertisementResource;

class HomeController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $ads = Advertisement::latest()->orderBy('created_at', 'desc')->get();

        $courses = Course::latest()->where('registration_end_date' , '>' , Carbon::today() )
        ->where('registration_start_date' , '<' , Carbon::today() )
        ->where('publish_status' , true )
        ->get();
        $data['courses'] = CourseResource::collection( $courses );
        $data['advertisement'] = AdvertisementResource::collection( $ads );

        return response()->json(['data'=>$data], 200);
    }




    public function posts()
    {
        $photoPosts = PhotoPost::latest()->orderBy('created_at', 'desc')->get();
        $polls = Poll::latest()->orderBy('created_at', 'desc')->get();


        $data['PhotoPost'] = PhotoPostResource::collection( $photoPosts );
        $data['polls'] = PollResource::collection( $polls );

        return response()->json(['data'=>$data], 200);
    }


}
