<?php

namespace App\Exceptions;

use Exception;
Use Throwable;


use Illuminate\Auth\AuthenticationException;
use Illuminate\Validation\ValidationException;
use Symfony\Component\Finder\Exception\AccessDeniedException;
use Illuminate\Foundation\Exceptions\Handler as ExceptionHandler;
use Symfony\Component\HttpKernel\Exception\TooManyRequestsHttpException;
use Spatie\Permission\Exceptions\UnauthorizedException as unauthenticated;
use Symfony\Component\HttpKernel\Exception\AccessDeniedHttpException;

class Handler extends ExceptionHandler
{
    /**
     * A list of the exception types that should not be reported.
     *
     * @var array
     */
    protected $dontReport = [
        \Illuminate\Auth\AuthenticationException::class,
        \Illuminate\Auth\Access\AuthorizationException::class,
        \Symfony\Component\HttpKernel\Exception\HttpException::class,
        \Illuminate\Database\Eloquent\ModelNotFoundException::class,
        \Illuminate\Session\TokenMismatchException::class,
        \Illuminate\Validation\ValidationException::class,
    ];

    /**
     * Report or log an exception.
     *
     * This is a great spot to send exceptions to Sentry, Bugsnag, etc.
     *
     * @param  \Exception  $exception
     * @return void
     */
    public function report(Throwable $exception)
    {
        parent::report($exception);
    }

    /**
     * Render an exception into an HTTP response.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Exception  $exception
     * @return \Illuminate\Http\Response
     */
    public function render($request,Throwable $exception)
    {
        /** 
         * Exception for user permission
         *   
         * $message  to store and return message 'user does not have permisson '
         **/
        if ($exception instanceof unauthenticated) {
           $message='User does not have right permission';
           $code=401;
           $content = array(
                'success' => false,
                'data' => 'something went wrong.',
                'message' => $message
            );
            return response($content)->setStatusCode($code);
        }

        /** 
         * Exception for user permission
         *   
         * $message  to store and return message 'user does not have permisson '
         **/
        if ($exception instanceof AccessDeniedHttpException) {
            $message='User does not  right permission';
            $code=401;
            $content = array(
                 'success' => false,
                 'data' => 'something went wrong.',
                 'message' => $message
             );
             return response($content)->setStatusCode($code);
         }

        /**
         * Exception for form validation
         * 
         * validating and getting first error 
         **/
        if ($exception instanceof ValidationException) {
            $validator = $exception->validator;
            $message = $validator->errors()->first();
            $code = \Illuminate\Http\Response::HTTP_UNPROCESSABLE_ENTITY;
            $content = array(
                'success' => false,
                'data' => 'something went wrong.',
                'message' => $message
            );
            return response($content)->setStatusCode($code);
        }
        /**
         * Throtling issue exception
         */
        if ($exception instanceof TooManyRequestsHttpException) {
           $message='To Many Request';
           $code=423;
           $content = array(
            'success' => false,
            'data' => 'something went wrong.',
            'message' => $message
            );
            return response($content)->setStatusCode($code);
        }
       
        return parent::render($request, $exception);
    }

    /**
     * Convert an authentication exception into an unauthenticated response.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Illuminate\Auth\AuthenticationException  $exception
     * @return \Illuminate\Http\Response
     */
    protected function unauthenticated($request, AuthenticationException $exception)
    {
        if ($request->expectsJson()) {
            $content = array(
                'success' => false,
                'data' => 'something went wrong.',
                'message' => 'User is unauthenticated'
                );
            return response($content)->setStatusCode(401);
            
        }

        return redirect()->guest(route('login'));
    }
}
