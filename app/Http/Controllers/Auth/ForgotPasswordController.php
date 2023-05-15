<?php

namespace App\Http\Controllers\Auth;
use App\Http\Controllers\AppBaseController;
use App\Http\Controllers\Controller;
use App\Mail\OtpVerificationMail;
use App\Models\PasswordReset;
use App\User;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Foundation\Auth\SendsPasswordResetEmails;
use Illuminate\Support\Facades\Mail;

use Illuminate\Support\Facades\Validator;

class ForgotPasswordController extends AppBaseController
{
    /*
    |--------------------------------------------------------------------------
    | Password Reset Controller
    |--------------------------------------------------------------------------
    |
    | This controller is responsible for handling password reset emails and
    | includes a trait which assists in sending these notifications from
    | your application to your users. Feel free to explore this trait.
    |
    */

    use SendsPasswordResetEmails;

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest');
    }
    /**
     * Function to send password on email or phone
     * 
     * @param Request $request
     */
    public function sendCode(Request $request){
        $user= User::where('email',$request->email)->pluck('id');
        date_default_timezone_set("Asia/Karachi");
        $time=Carbon::now()->addMinutes(15)->format('Y-m-d H:i:s');
        $code=rand(1000,9999);
        $password= PasswordReset::create([
            'user_id'=>$user[0],
            'code'=>$code,
            'expiry'=>$time,

        ]);
        $details = [
            'subject' => 'Testing Application code',
            'body' => 'Your code is : '. $code
        ];
        //mailing otp to the user
        Mail::to($request->email)->send(new OtpVerificationMail($details));

        return $this->sendSuccess('code sent');
    }

    /**
     * Match code 
     * 
     * @param Request $request
     */
    public function checkCode(Request $request){
        $user= User::where('email',$request->email)->pluck('id');
        $password= PasswordReset::where('user_id',$user[0])->where('code',$request->code)->exists();
        if($password){
            return $this->sendSuccess('Verified'); 
        }else{
            return $this->sendError('Wrong code'); 
        }
    }
    /**
     * Reset password 
     * 
     * @param Request $request
     * @return success
     */
    public function passwordReset(Request $request){
        $validator = Validator::make($request->all(), [ 
            'password' => 'required', 
            'confirm_password' => 'required|same:password', 
        ]);
        if ($validator->fails()) { 
            return $this->sendError($validator->errors(),422);              
        }
        $user= User::where('email',$request->email)->update([
            'password'=>bcrypt($request->password)
        ]);
        return $this->sendSuccess('Updated'); 
    }
}
