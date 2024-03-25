<?php

namespace App\Http\Controllers\Api\Course;

use Carbon\Carbon;
use App\Models\Enroll;
use App\Models\Booking;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Resources\BookingResource;
use App\Http\Requests\Booking\BookingStoreRequest;
use App\Http\Requests\Course\CourseCheckInRequest;
use App\Http\Requests\Booking\BookingApproveRequest;
use App\Http\Requests\Booking\BookingCheckInRequest;
use App\Models\Student;

class BookingController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(CourseCheckInRequest $request)
    {
        $bookingRequests = Booking::where('course_id' , $request->course_id)->get();
        return response()->json(['data'=> BookingResource::collection($bookingRequests) ], 200) ;
    }

    /**
     * Display a listing of the resource for current user.
     */
    public function MyBookingRequests(CourseCheckInRequest $request)
    {
        //show user booking list to make him able to update or delete booking request after that
        $bookingRequests =Booking::where('user_id' , auth()->user()->id )->where('registration_end_date', null)->get();
        return response()->json(['data'=> BookingResource::collection($bookingRequests) ], 200) ;
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(BookingStoreRequest $request)
    {
        $inputs = $request->all();
        $inputs['user_id'] = auth()->user()->id;
        $inputs['date'] = Carbon::now();
        $bookingRequest = Booking::create($inputs);
        return response()->json(['msg'=>'Course booking has been added'], 200) ;
    }

    /**
     * approve Student booking Request with passing parameter in URL.
     */
    public function approveStudentRequest(BookingApproveRequest $request)
    {
        $bookingRequest = Booking::find($request->book_id);
        $bookingRequest->update(['status' => true]);

        $user = $bookingRequest->user;
        $user->role_id = 4;
        $user->save();

        $student = Student::updateOrCreate(
            ['user_id' => $user->id],
            ['joining_date' => Carbon::today()]
        );

        $enroll = Enroll::create([
            'user_id'=> $user->id,
            'course_id'=> $bookingRequest->course_id
        ]);


        return response()->json(['msg' => 'Student request approved successfully.',]);
    }

    /**
     * reject Student booking Request with passing parameter in URL.
     */
    public function rejectStudentRequest(BookingApproveRequest $request)
    {
        $bookingRequest = Booking::find($request->book_id)->update(['status' => false]);
        return response()->json(['msg' => 'Student request rejected successfully.',]);
    }

    /**
     * Display the specified resource.
     */
    public function show(BookingCheckInRequest $request)
    {
        $bookRequest = Booking::find($request->book_id);
        return response()->json([
            'message'=> "Successfull",
            'data'=> new BookingResource( $bookRequest )
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
    public function destroy(BookingCheckInRequest $request)
    {
        $bookingRequest = Booking::find($request->book_id)->delete();
        return response()->json(['msg'=>'booking request has been deleted'], 200) ;
    }
}
