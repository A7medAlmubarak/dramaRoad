<?php

namespace App\Http\Controllers\Api\Auth;

use App\Models\User;
use App\Models\EmailVerify;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\DB;
use App\Mail\EmailVerificationMail;
use App\Http\Controllers\Controller;
use App\Http\Resources\UserResource;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use App\Http\Requests\Auth\LoginUserRequest;
use App\Http\Requests\Auth\RegisterUserRequest;

class UserController extends Controller
{

    public function register(RegisterUserRequest $request)
    {
        DB::beginTransaction();
        try {
            $user = $request->all();
            /************** create username *****************/
            $username = str_replace (' ', '',  $request->name);
            $username = strtolower($username);
            $count = 1;
            $baseUsername = $username;
            while (User::where('username', $username)->exists()) {
                $username = $baseUsername . $count;
                $count++;
            }

            $user['username']= $username;
            $user['password'] = Hash::make($user['password']);
            User::create($user);

            $emailVerify = EmailVerify::updateOrCreate(
                ['email' => $user['email'],
                'token' => Str::random(255),
                'expired_at' => Carbon::now()->addMinutes(5)
                ]
            );
            Mail::to($user['email'])->send(
                new EmailVerificationMail(route('mail.verify', ['token' => $emailVerify->token]))
            );
            DB::commit();
            return response()->json([ 'message' => 'Your Verification message has been sent to your email , plz verify your email before login']);
        } catch (\Throwable $th) {
            DB::rollBack();
            throw $th;
        }
    }

    /**************************************************************************************/

    public function verifyEmail(Request $request)
    {
        $emailVerify = EmailVerify::where('token', $request->token)->first();
        if (!$emailVerify) {
            return response()->json([ 'message' => 'Invalid verification link' ]);
        }
        if (Carbon::now()->greaterThan($emailVerify->expired_at)) {
            return response()->json([ 'message' => 'Verification link expired' ]);
        }
        $user = User::where('email', $emailVerify->email)->first();
        $user->update(['email_verified_at' => Carbon::now()]);
        $emailVerify->delete();
        return response()->json([ 'message' => 'Your account has been verified' ]);
    }

    /**********************************************************************************************/

    public function login(LoginUserRequest $request)
    {
        if (filter_var($request->login_field, FILTER_VALIDATE_EMAIL)) {
            $field = 'email';
        } else {
            $field = 'username';
        }

        if (Auth::attempt([$field => $request->login_field, 'password' => $request->password])){
            /** @var \App\Models\User $user **/
            $user = Auth::user();
            if ($user->email_verified_at === null) {
                return response()->json(['message' => 'Email not verified'], 401);
            }
            $user ['token'] = $user->createtoken('A7med')->accessToken;
            return response()->json(['msg'=>'User login successfully' ,'user'=>$user  ], 200);
        }
        else{
            return response()->json(['somthing went wrong , please try again'],404 );
        }
    }

    public function userList()
    {
            $users = User::where('role_id' , 5)->get();
            return response()->json(['data'=> UserResource::collection( $users ) ], 200) ;
    }

    public function userAll()
    {
            $users = User::get();
            return response()->json(['data'=> UserResource::collection( $users ) ], 200) ;
    }

    



}
