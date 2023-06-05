<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\AppBaseController;
use App\Models\Product;
use App\Http\Controllers\Controller;
use App\Http\Requests\StoreProductRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class ProductController extends AppBaseController
{
    public function index()
    {
        return Product::all();
    }

    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'reseller_product_id' => 'nullable|numeric',
            'name' => 'required|string',
            'description' => 'nullable|string',
            'brand' => 'nullable|string',
            'sizes' => 'nullable|string',
            'sku' => 'nullable|string',
            'product_tag' => 'nullable|string',
            'slug' => 'nullable|string',
            'hasStock' => 'required|boolean',
            'profit_margin' => 'required|numeric',
            'price' => 'required|numeric',
            'discount' => 'nullable|numeric',
            'discount_price' => 'nullable|numeric',
            'resaler_price' => 'nullable|numeric',
            'stock' => 'required|integer',
            'category_id' => 'nullable|numeric',
            'images' => 'nullable|array',
            'images.*' => 'image|max:2048',
        ]);
       
        // Handle image upload
        $imagePaths = [];
        if ($request->hasFile('images')) {
            foreach ($request->images as $image) {
                $path = Storage::disk('s3')->put('category', $image);
                $imagePaths[] = Storage::disk('s3')->url($path);   
            }
        }

        // Create a new instance of the Product model with the validated data
        $product = Product::create($request->all());

        // Attach the image paths to the product
        $product->images()->createMany(
            array_map(function ($imagePath) {
                return ['image' => $imagePath];
            }, $imagePaths)
        );

        // Optionally, you can perform additional actions or return a response here

        // Return a success response or redirect
        return response()->json(['message' => 'Data inserted successfully'], 201);
    }

    public function updateStatus($id,$status)
    {
        Product::whereId($id)->update([
            'status'=>$status
        ]);

        return $this->sendSuccess('Updated');
    }
}
