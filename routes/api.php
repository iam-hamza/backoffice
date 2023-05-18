<?php

use App\Http\Controllers\Admin\UsersController;
use App\Http\Controllers\Admin\BannerController;
use App\Http\Controllers\Admin\ResellerProductController;

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
        Route::post('/password-resets', 'Auth\ForgotPasswordController@passwordReset');

    /**
     * Extra routes
     */


    /**Login client and Artist */
    Route::post('/login', 'Auth\LoginController@login');
 

    Route::group(['middleware' => ['auth:api','role:administrator|user']], function () {
        // /**Roles routes for roles and permission */ 
        Route::group(['prefix' => '/roles'], function () {
            Route::get('/', 'Admin\RolesController@index');
            Route::post('/', 'Admin\RolesController@store');
            Route::get('/{id}', 'Admin\RolesController@show');
            Route::post('/{role}', 'Admin\RolesController@update');
        });

        Route::group(['prefix' => '/users'], function () {
            Route::get('/', [UsersController::class, 'index']);
            Route::post('/', [UsersController::class, 'store']);
            Route::get('/{user}', [UsersController::class, 'show']);
            Route::post('/{user}', [UsersController::class, 'update']);
            Route::delete('/{user}', [UsersController::class, 'destroy']);
        });

        Route::group(['prefix' => '/banners'], function () {
            Route::get('/', [BannerController::class, 'index']);
            Route::post('/', [BannerController::class, 'store']);
            Route::post('/{banner}', [BannerController::class, 'update']);
            Route::delete('/{banner}', [BannerController::class, 'destroy']);
        });

        Route::group(['prefix' => '/reseller'], function () {
            Route::get('/', [ResellerProductController::class, 'index']);
        });


    });



