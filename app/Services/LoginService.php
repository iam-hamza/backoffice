<?php

namespace App\Services;

use App\Http\Controllers\AppBaseController;
use App\User;
use Auth;
use Symfony\Component\HttpKernel\Exception\UnprocessableEntityHttpException;

class LoginService extends AppBaseController 
{ 

    public function userLogin($request){

        if(Auth::attempt(['email' => request('email'), 'password' => request('password')])){ 
            $user = Auth::user(); 
            $success['token'] =  $user->createToken('MyApp')-> accessToken; 
            $success['user'] =  $user;

            return $success; 

        }else{ 

            if(User::where('email',request('email'))->first()){
               
                throw new UnprocessableEntityHttpException('Password is wrong');
            }else{

                throw new UnprocessableEntityHttpException('Email is Wrong');
            }
            
        } 

    }
    public function webLogin(){

        if(Auth::attempt(['email' => request('email'), 'password' => request('password')])){ 

            $user = Auth::user(); 
            $success['token'] =  $user->createToken('MyApp')-> accessToken; 
            $success['user'] =  $user;
            $success['role'] =  $user->getRoleNames();

            if($success['role'][0]=='customer' || $success['role'][0]=='artist'){
                 return $this->sendError('Unautherized',422); 
            }

            return $success; 
        }else{ 
            if(User::where('email',request('email'))->first()){

                throw new UnprocessableEntityHttpException('Password is wrong');
            }else{

                throw new UnprocessableEntityHttpException('Email is Wrong');
            }
            
        } 
    }
}