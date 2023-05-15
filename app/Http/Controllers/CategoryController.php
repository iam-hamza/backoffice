<?php

namespace App\Http\Controllers;

use Throwable;
use App\Models\Category;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use Illuminate\Http\Client\HttpClientException;
use App\Http\Requests\Category\CategoryRequest;

class CategoryController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        try{
            $categories = Category::with('subCategories')->whereCategoryId(null)->paginate($request->perPage);

            if ($categories->total() == 0) {
                throw new HttpClientException(
                    Response::$statusTexts[Response::HTTP_NO_CONTENT], 
                    Response::HTTP_NO_CONTENT
                );
            }
            return $this->success(
                $categories,Response::$statusTexts[Response::HTTP_FOUND],
                Response::HTTP_OK
            );
          
        }catch(Throwable $exception){
            if ($exception instanceof HttpClientException) {
                return $this->failed($exception->getMessage(), $exception->getCode());
            }
            return $this->failed(statusCode: Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }


    /**
     * Store a newly created resource in storage.
     */
    public function store(CategoryRequest $request)
    {
        try{
            $category = Category::create($request->prepareRequest());

            if (!$category) {
                throw new HttpClientException(
                    Response::$statusTexts[Response::HTTP_NO_CONTENT], 
                    Response::HTTP_NO_CONTENT
                );
            }
            return $this->success(
                $category,
                Response::$statusTexts[Response::HTTP_CREATED],
                Response::HTTP_CREATED
            );

        }catch(Throwable $exception){
            if ($exception instanceof HttpClientException) {
                return $this->failed($exception->getMessage(), $exception->getCode());
            }
            return $this->failed(statusCode: Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }

    /**
     * Display the specified resource.
     */
    public function show( string $id)
    {
        try{
            $category = Category::whereId($id)->with('subCategories')->first();

            if (!$category) {
                throw new HttpClientException(
                    Response::$statusTexts[Response::HTTP_NO_CONTENT], 
                    Response::HTTP_NO_CONTENT
                );
            }
            return $this->success(
                $category,
                Response::$statusTexts[Response::HTTP_FOUND],
                Response::HTTP_OK
            );

        }catch(Throwable $exception){
            if ($exception instanceof HttpClientException) {
                return $this->failed($exception->getMessage(), $exception->getCode());
            }
            return $this->failed(statusCode: Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }


    /**
     * Update the specified resource in storage.
     */
    public function update(CategoryRequest $request, string $id)
    {
        try{
            $category = Category::whereId($id)->first();

            if (!$category) {
                throw new HttpClientException(
                    Response::$statusTexts[Response::HTTP_NO_CONTENT], 
                    Response::HTTP_NO_CONTENT
                );
            }

            $category->update($request->prepareRequest());

            return $this->success(
                $category,
                'Updated',
                Response::HTTP_CREATED
            );

        }catch(Throwable $exception){
            if ($exception instanceof HttpClientException) {
                return $this->failed($exception->getMessage(), $exception->getCode());
            }
            return $this->failed(statusCode: Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        try{
            $category = Category::whereId($id)->delete();

            
            if (!$category) {
                throw new HttpClientException(
                    Response::$statusTexts[Response::HTTP_NO_CONTENT], 
                    Response::HTTP_NO_CONTENT
                );
            }
            return $this->success(
                $category,
                'Deleted',
                Response::HTTP_OK
            );

        }catch(Throwable $exception){
            if ($exception instanceof HttpClientException) {
                return $this->failed($exception->getMessage(), $exception->getCode());
            }
            return $this->failed(statusCode: Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }
}
