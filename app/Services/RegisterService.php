<?php
namespace App\Services;

use App\Http\Controllers\AppBaseController;
use App\User;
use Auth;
use Exception;
use Symfony\Component\HttpKernel\Exception\UnprocessableEntityHttpException;

class RegisterService extends AppBaseController { 

    public function register($request){
        try{
            $input = $request->all(); 
            $input['password'] = bcrypt($input['password']); 

            //genrating uuid 
            $uuid= $this->genrateUuid();
            $input['uuid']=$uuid;

            //genrating otp for verification
            $otp = rand(1000,9999);
            $input['otp']=$otp;
            $user = User::create($input);

            //assign role to customer
            $user->assignRole('customer');
            
            $details = [
                'subject' => 'Testing Application OTP',
                'body' => 'Your OTP is : '. $otp
            ];

            //mailing otp to the user
            Mail::to($request->email)->send(new OtpVerificationMail($details));

            return $this->sendSuccess('OTP sent');
            
        }catch(Exception $e){

            throw new UnprocessableEntityHttpException($e->getMessage());
        }
      
    }
   
}