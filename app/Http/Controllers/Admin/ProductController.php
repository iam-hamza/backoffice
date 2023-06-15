<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\AppBaseController;
use App\Models\Product;
use App\Http\Controllers\Controller;
use App\Http\Requests\StoreProductRequest;
use App\Models\ResellerProduct;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class ProductController extends AppBaseController
{
    public function index(Request $request)
    {
        return Product::when($request->has('name'),function($q) use($request){
            $q->where('name', 'LIKE', '%' . $request->name . '%');
            $q->orWhere('sku', 'LIKE', '%' . $request->name . '%');
        })
        ->when($request->has('brand'),function($q) use($request){
            $q->where('brand',$request->brand);
        })
        ->when($request->has('category'),function($q) use($request){
            $q->where('category_id',$request->category);
        })
        ->with('images')
        ->paginate($request->per_page)
        ->withQueryString();
        
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
        ]);
       
        // Handle image upload
        $imagePaths = json_decode($request->images);
     
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
        return $this->show($product->id);
    }


    public function update(Request $request,$id)
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
        ]);
       
        

        // Create a new instance of the Product model with the validated data
        $product = Product::findOrFail($id);
        $product->update($validatedData);

        $product->images()->delete();
        // Attach the image paths to the product
        $images = json_decode($request->images);
       
        $product->images()->createMany(
            array_map(function ($images) {
                return ['image' => $images];
            }, $images)
        );

        // Return a success response or redirect
        return $this->show($id);
    }

    public function show($id)
    {
        return Product::whereId($id)->with(['images','category'])->first();

    }

    public function updateStatus($id,$status)
    {
        $product =  Product::findOrFail($id);
        $product->update([
            'status'=>$status
        ]);
        $status = 1 ? $status : $status = 2; 
        ResellerProduct::whereId($product->reseller_product_id)->update([
            'status' => $status,
        ]);

        return $this->sendSuccess('Updated');
    }
}
