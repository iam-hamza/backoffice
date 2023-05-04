<?php

use Admin\UsersController;
use App\User;

Route::group(['prefix' => '/v1', 'namespace' => 'Api\V1', 'as' => 'api.'], function () {

});

    /**
     * Extra routes
     */

        /**Login Admin and other user for webpannel*/
        Route::post('/web-login', 'Auth\LoginController@webLogin');

        /**Register Client */
        Route::post('/register', 'Auth\RegisterController@registerClientApi');
    

        /**Register Artist */
        Route::post('/register-artist', 'Auth\RegisterController@registerArtistApi');

        /**Otp email verification */
        Route::post('/otp', 'Auth\RegisterController@otpSent');

        /**Otp email verification */
        Route::post('/email-otp-verification', 'Auth\RegisterController@otpVerification');

        /**Forget password */
        Route::post('/forget-password', 'Auth\ForgotPasswordController@sendCode');
        Route::post('/forget-password-verification', 'Auth\ForgotPasswordController@checkCode');

        /**Password Reset */
        Route::post('/password-reset', 'Auth\ForgotPasswordController@passwordReset');

    /**
     * Extra routes
     */


    /**Login client and Artist */
    Route::post('/login', 'Auth\LoginController@login');
 

    Route::group(['middleware' => ['auth:api','role:administrator|user']], function () {
        // /**Roles routes for roles and permission */ 
        Route::group(['prefix' => '/roles'], function () {
            Route::get('/', 'Admin\RolesController@index')->middleware('permission:users_manage');
            Route::post('/', 'Admin\RolesController@store')->middleware('cors');
            Route::get('/{id}', 'Admin\RolesController@edit');
            Route::post('/{role}', 'Admin\RolesController@update');
        });
        Route::apiResource('users', UsersController::class);
    });



