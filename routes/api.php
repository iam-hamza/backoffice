<?php

use Spatie\Permission\Models\Role;
use App\Http\Controllers\Admin\ImageController;
use App\Http\Controllers\Admin\UsersController;
use App\Http\Controllers\Admin\BannerController;
use App\Http\Controllers\Admin\ProductController;
use App\Http\Controllers\Admin\ProfileController;
use App\Http\Controllers\Admin\CategoryController;
use App\Http\Controllers\Admin\SubCategoryController;
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
    Route::post('/test', function(){
        $role = Role::find(1);
        $role->syncPermissions([
            'roles.index',
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
        ]);
       
    });
 
    Route::group(['prefix' => 'app'], function () {
        // /**Roles routes for roles and permission */ 
        Route::group(['prefix' => '/banners'], function () {
            Route::get('/', 'MobileApp\BannersController@index');
        });

        Route::group(['prefix' => '/showroom'], function () {
            Route::get('/', 'MobileApp\ShowRoomProductController@index');
        });

        Route::group(['prefix' => '/product'], function () {
            Route::get('/', 'MobileApp\ProductController@index');
        });

    });

    Route::group(['middleware' => ['auth:api']], function () {
        // /**Roles routes for roles and permission */ 
        Route::group(['prefix' => '/roles'], function () {
            Route::get('/', 'Admin\RolesController@index');
            Route::post('/', 'Admin\RolesController@store')->middleware("permission:roles.store");
            Route::get('/{id}', 'Admin\RolesController@show')->middleware("permission:roles.show");
            Route::post('/{role}', 'Admin\RolesController@update')->middleware("permission:roles.update");
        });
        
        Route::group(['prefix' => '/users'], function () {
            Route::get('/', [UsersController::class, 'index'])->middleware("permission:users.index");
            Route::post('/', [UsersController::class, 'store'])->middleware("permission:users.store");
            Route::get('/{user}', [UsersController::class, 'show'])->middleware("permission:users.show");
            Route::post('/{user}', [UsersController::class, 'update'])->middleware("permission:users.update");
            Route::delete('/{user}', [UsersController::class, 'destroy'])->middleware("permission:users.destroy");
        });
        
        Route::group(['prefix' => '/banners'], function () {
            Route::get('/', [BannerController::class, 'index'])->middleware("permission:banners.index");
            Route::post('/', [BannerController::class, 'store'])->middleware("permission:banners.store");
            Route::post('/{banner}', [BannerController::class, 'update'])->middleware("permission:banners.update");
            Route::delete('/{banner}', [BannerController::class, 'destroy'])->middleware("permission:banners.destroy");
        });
        
        Route::group(['prefix' => '/reseller'], function () {
            Route::get('/', [ResellerProductController::class, 'index'])->middleware("permission:reseller.index");
            Route::get('/category', [ResellerProductController::class, 'categories']);
            Route::get('/show/{id}', [ResellerProductController::class, 'show']);
            Route::get('/website', [ResellerProductController::class, 'website']);
            Route::post('/add-to-product', [ResellerProductController::class, 'addToProduct']);


        });

        Route::group(['prefix' => '/category'], function () {
            Route::get('/', [CategoryController::class, 'index']);
            Route::get('/{category}', [CategoryController::class, 'show']);
            Route::post('/', [CategoryController::class, 'store']);
            Route::post('/{id}', [CategoryController::class, 'update']);
            Route::delete('/{id}', [CategoryController::class, 'destroy']);

        });

        Route::group(['prefix' => '/product'], function () {
            Route::get('/', [ProductController::class, 'index']);
            Route::get('/{product}', [ProductController::class, 'show']);
            Route::post('/', [ProductController::class, 'store']);
            Route::post('/{id}', [ProductController::class, 'update']);
            Route::delete('/{id}', [ProductController::class, 'destroy']);
            Route::get('update-status/{id}/{status}', [ProductController::class, 'updateStatus']);
            Route::get('is_showroom/{product}', [ProductController::class, 'isShowroom']);



        });

        Route::group(['prefix' => '/profile'], function () {
            Route::get('/', [ProfileController::class, 'index']);
        });

        Route::group(['prefix' => '/image'], function () {
            Route::post('/', [ImageController::class, 'store']);
        });

        Route::group(['prefix' => '/subcategories'], function () {
            Route::get('', [SubCategoryController::class, 'index']);
            Route::post('', [SubCategoryController::class, 'store']);
            Route::post('/{subcategory}', [SubCategoryController::class, 'update']);
            Route::get('/{subcategory}', [SubCategoryController::class, 'show']);
        });

    });



