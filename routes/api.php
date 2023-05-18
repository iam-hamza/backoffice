<?php

use App\Http\Controllers\Admin\UsersController;
use App\Http\Controllers\Admin\BannerController;
use App\Http\Controllers\Admin\ResellerProductController;
use Spatie\Permission\Models\Role;

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
    Route::post('/test', function(){
        $role = Role::find(1);
        $role->syncPermissions([
            'roles.index',
            'roles.store',
            'roles.show',
            'roles.update',
            'users.index',
            'users.store',
            'users.show',
            'users.update',
            'users.destroy',
            'banners.index',
            'banners.store',
            'banners.update',
            'banners.destroy',
            'reseller.index',
        ];);
       
    });
 


    Route::group(['middleware' => ['auth:api','role:administrator|user']], function () {
        // /**Roles routes for roles and permission */ 
        Route::group(['prefix' => '/roles'], function () {
            Route::get('/', 'Admin\RolesController@index')->middleware("can:roles.index");
            Route::post('/', 'Admin\RolesController@store')->middleware("can:roles.store");
            Route::get('/{id}', 'Admin\RolesController@show')->middleware("can:roles.show");
            Route::post('/{role}', 'Admin\RolesController@update')->middleware("can:roles.update");
        });
        
        Route::group(['prefix' => '/users'], function () {
            Route::get('/', [UsersController::class, 'index'])->middleware("can:users.index");
            Route::post('/', [UsersController::class, 'store'])->middleware("can:users.store");
            Route::get('/{user}', [UsersController::class, 'show'])->middleware("can:users.show");
            Route::post('/{user}', [UsersController::class, 'update'])->middleware("can:users.update");
            Route::delete('/{user}', [UsersController::class, 'destroy'])->middleware("can:users.destroy");
        });
        
        Route::group(['prefix' => '/banners'], function () {
            Route::get('/', [BannerController::class, 'index'])->middleware("can:banners.index");
            Route::post('/', [BannerController::class, 'store'])->middleware("can:banners.store");
            Route::post('/{banner}', [BannerController::class, 'update'])->middleware("can:banners.update");
            Route::delete('/{banner}', [BannerController::class, 'destroy'])->middleware("can:banners.destroy");
        });
        
        Route::group(['prefix' => '/reseller'], function () {
            Route::get('/', [ResellerProductController::class, 'index'])->middleware("can:reseller.index");
        });


    });



