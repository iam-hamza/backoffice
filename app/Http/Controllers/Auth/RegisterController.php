<?php

namespace App\Http\Controllers\Auth;

use App\User;
use App\Http\Controllers\Controller;
use App\Mail\OtpVerificationMail;
use Exception;
use Illuminate\Support\Facades\Validator;
use Illuminate\Foundation\Auth\RegistersUsers;
use Illuminate\Http\Request;
use App\Http\Controllers\AppBaseController;
use App\Http\Requests\Auth\RegisterRequest;
use App\Models\ArtistProfile;
use Illuminate\Support\Facades\Mail;
class RegisterController extends AppBaseController
{
    /*
    |--------------------------------------------------------------------------
    | Register Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles the registration of new users as well as their
    | validation and creation. By default this controller uses a trait to
    | provide this functionality without requiring any additional code.
    |
    */

    use RegistersUsers;

    /**
     * Where to redirect users after registration.
     *
     * @var string
     */
    protected $redirectTo = '/admin/home';

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
     * Get a validator for an incoming registration request.
     *
     * @param  array  $data
     * @return \Illuminate\Contracts\Validation\Validator
     */
    protected function validator(array $data)
    {
        return Validator::make($data, [
            'first_name' => 'required|string|max:255',
            'last_name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|min:8|confirmed',
        ]);
    }

    /**
     * Create a new user instance after a valid registration.
     *
     * @param  array  $data
     * @return User
     */
    protected function create(array $data)
    {
        return User::create([
            'first_name' => $data['first_name'],
            'last_name' => $data['last_name'],
            'email' => $data['email'],
            'password' => bcrypt($data['password']),
        ]);
    }

    /**
     * Register Client Api 
     * 
     * @param Request $request
     * @return json success
     */
    public function registerClientApi(RegisterRequest $request) 
    { 
       
        try{
           
        }catch(Exception $e){
            return $this->sendError($e->getMessage(),422);
        }    
    }

     /**
     * Register Artist Api 
     */
    public function registerArtistApi(Request $request) 
    { 
        $validator = Validator::make($request->all(), [ 
            'full_name' => 'required',  
            'email' => 'unique:users', 
            'phone' => 'unique:users',
            'password' => 'required', 
            'confirm_password' => 'required|same:password', 
        ]);
        if ($validator->fails()) { 
            return $this->sendError($validator->errors(),422);              
        }
        try{
           
            $input = $request->all(); 
            $input['password'] = bcrypt($input['password']); 

            //genrating uuid 
            $uuid= $this->genrateUuid();
            $input['uuid']=$uuid;

            //genrating otp for verification
            $otp = rand(1000,9999);
            $input['otp']=$otp;

            //Create User
            $user = User::create($input);

            //assign role to the user
            $user->assignRole('artist');

            //Adding User to Artist Table
            ArtistProfile::create([
                'user_id'=>$user->id
            ]);

            //Seeting email things 
            $details = [
                'subject' => 'Testing Application OTP',
                'body' => 'Your OTP is : '. $otp
            ];

            //mailing otp to the user
            Mail::to($request->email)->send(new OtpVerificationMail($details));

            return $this->sendSuccess('OTP sent');
        }catch(Exception $e){
            return $this->sendError($e->getMessage(),422);  
        }    
    }
    /**
     * Otp Send To email
     * 
     * @param Request $request
     * @return response
     */
    public function otpSent(Request  $request){
        $otp = rand(1000,9999);
        $input['otp']=$otp;
        $user= User::where('email',$request->email)->update([
            'otp'=>$otp
        ]);
        $details = [
            'subject' => 'Testing Application code',
            'body' => 'Your code is : '. $otp
        ];
        //mailing otp to the user
        Mail::to($request->email)->send(new OtpVerificationMail($details));

        return $this->sendSuccess('code sent');

    }
     /**
     * Otp verification
     * verifying otp through otp
     */
    public function otpVerification(Request $request ){
        $user=User::where('email',$request->email)->where('otp',$request->otp)->first();
   
        if(isset($user)){

            $user->update([
                'otp'=>null,
            ]);
            $success['token'] =  $user->createToken('MyApp')->accessToken; 
            $success['user'] =  $user;
            $success['role'] =  $user->getRoleNames();
            return response()->json(['success'=>$success]);
        }else{
            return $this->sendError('Otp Not Matched',422);  
        }
        
    }

    /**
     * Function to update the uuid
     * 
     *@param ID  
     */
    public function genrateUuid(){
        $user=User::latest('uuid')->first();
        $uuid=$user->uuid+1;
        return $uuid;
    }
}
