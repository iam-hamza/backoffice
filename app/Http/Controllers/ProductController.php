<?php

namespace App\Http\Controllers;

use Throwable;
use App\Models\Product;
use App\Models\ProductImage;
use Illuminate\Http\Request;
use App\Http\Requests\Product\ProductRequest;
use Symfony\Component\HttpFoundation\Response;
use Illuminate\Http\Client\HttpClientException;
use App\Http\Controllers\Traits\Product\ProductTrait;

class ProductController extends Controller
{
    use ProductTrait;
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        try{
            $products = Product::with('images')->paginate($request->perPage);

            if ($products->total() == 0) {
                throw new HttpClientException(
                    Response::$statusTexts[Response::HTTP_NO_CONTENT], 
                    Response::HTTP_NO_CONTENT
                );
            }
            return $this->success(
                $products,
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
     * Store a newly created resource in storage.
     */
    public function store(ProductRequest $request)
    {
        try{
            $fileImages = $this->multipleImagesUpload($request->file('images'));
            $product = Product::create($request->prepareRequest());

            if (!$product) {
                throw new HttpClientException(
                    Response::$statusTexts[Response::HTTP_NO_CONTENT], 
                    Response::HTTP_NO_CONTENT
                );
            }

            foreach ($fileImages ?? [] as $fileImage) {
                ProductImage::create([
                    'image' => $fileImage,
                    'product_id'=>$product->id
                ]);
            }
          
            return $this->success(
                $product,
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
    public function show(string $id)
    {
        try{
            $product = Product::with('images')->whereId($id)->first();

            if (!$product) {
                throw new HttpClientException(
                    Response::$statusTexts[Response::HTTP_NO_CONTENT], 
                    Response::HTTP_NO_CONTENT
                );
            }

            return $this->success(
                $product,
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
    public function update(ProductRequest $request)
    {
        try{
            $fileImages = $this->multipleImagesUpload($request->file('images'));
            $product = Product::whereId($request->id)->first();

            if (!$product) {
                throw new HttpClientException(
                    Response::$statusTexts[Response::HTTP_NO_CONTENT], 
                    Response::HTTP_NO_CONTENT
                );
            }

            $product->update($request->prepareRequest());

            foreach ($fileImages ?? [] as $fileImage) {
                ProductImage::create([
                    'image'=>$fileImage,
                    'product_id'=>$product->id
                ]);
            }    

            return $this->success(
                $product,
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
            $product = Product::find($id);
          
            if (!$product) {
                throw new HttpClientException(
                    Response::$statusTexts[Response::HTTP_NO_CONTENT], 
                    Response::HTTP_NO_CONTENT
                );
            }

            $product->images()->delete();
            $product->delete();
            
            return $this->success(
                $product,
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

        /**
     * Remove the specified resource from storage.
     */
    public function deleteImage(string $id)
    {
        try{
            $product = ProductImage::whereId($id)->first();
            if ($product) {
                if (file_exists("public/{$product->image}")) {
                    unlink($product->image);
                }
                $product->delete();
                return $this->success([],'Deleted',Response::HTTP_OK);
            }else{
                return $this->failed(Response::$statusTexts[Response::HTTP_NO_CONTENT],Response::HTTP_NO_CONTENT);
            }
        }catch(Throwable $exception){
            if ($exception instanceof HttpClientException) {
                return $this->failed($exception->getMessage(), $exception->getCode());
            }
            return $this->failed(statusCode: Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }
}
