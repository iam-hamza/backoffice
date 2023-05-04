<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Socialite;
use Auth;
use App\User;
use Illuminate\Http\Request;
use App\Http\Controllers\AppBaseController;
use App\Http\Requests\Auth\LoginRequest;
use App\Services\LoginService;
use App\Services\UserService;
use Exception;

class LoginController extends AppBaseController
{
    /*
    |--------------------------------------------------------------------------
    | Login Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles authenticating users for the application and
    | redirecting them to your home screen. The controller uses a trait
    | to conveniently provide its functionality to your applications.
    |
    */

    use AuthenticatesUsers;
    
    /**
     * Where to redirect users after login / registration.
     *
     * @var string
     */
  
    
   
    private  $loginService;
    /**
     * Create a new controller instance.
     *
     * @return void
     */

    public function __construct(LoginService $loginService)
    {
        $this->loginService = $loginService;
    }

    /**
     * login api
     * 
     * @return Json response 
     */
    public function login(LoginRequest $request){ 
        try{
            $response=  $this->loginService->userLogin($request->all());

            return $this->response($response);
            
        }catch(Exception $e){
        
            return $this->sendError($e->getMessage());
        }
    }

    /**
     * Admin Login 
     * 
     * @return user 
     */
    public function webLogin(LoginRequest $request){ 
        try{
            $response=  $this->loginService->webLogin($request->all());

            return $this->response($response);
            
        }catch(Exception $e){
        
            return $this->sendError($e->getMessage());
        }
      
   }
    
}
