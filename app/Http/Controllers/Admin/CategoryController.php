<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\AppBaseController;
use App\Http\Controllers\Controller;
use Throwable;
use App\Models\Category;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use Illuminate\Http\Client\HttpClientException;


class CategoryController extends AppBaseController
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
      
        // try{
            $categories = Category::get();


            return $this->sendSuccess(
                $categories,Response::$statusTexts[Response::HTTP_FOUND],
                Response::HTTP_OK
            );
          
        // }catch(Throwable $exception){
        //     if ($exception instanceof HttpClientException) {
        //         return $this->sendError($exception->getMessage(), $exception->getCode());
        //     }
        //     return $this->sendError('Some Thing Wrong' ,Response::HTTP_INTERNAL_SERVER_ERROR);
        // }
    }

}
