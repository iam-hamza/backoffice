<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\AppBaseController;
use App\Http\Controllers\Controller;
use App\Http\Requests\AddResellerProductsToProducts;
use App\Http\Resources\ResellerProducrReseource;
use App\Http\Resources\SingleProductResource;
use App\Models\Product;
use App\Models\ProductImage;
use App\Models\ResellerCategory;
use App\Models\ResellerProduct;
use Illuminate\Http\Request;

class ResellerProductController extends AppBaseController
{
    public function index(Request $request)
    {
        
        $product = ResellerProduct::
        when($request->has('website'),function($q) use($request){
            $q->where('website',$request->website);
        })
        ->when($request->has('category'),function($q) use($request){
            $q->where('categories', 'LIKE', '%' . $request->category . '%');
        })
        ->when($request->has('name'),function($q) use($request){
            $q->where('name', 'LIKE', '%' . $request->name . '%');
            $q->orWhere('sku', 'LIKE', '%' . $request->name . '%');
        })
        ->paginate($request->per_page)->withQueryString();
        
        return new ResellerProducrReseource($product);
    }

    public function show($id)
    {
       
        $product = ResellerProduct::
                    whereId($id)->get();
        
        return SingleProductResource::collection($product);
    }


    public function categories(Request $request)
    {
       
        return ResellerCategory::where('website',$request->website)->get();
    }

    public function addToProduct(AddResellerProductsToProducts $request)
    {
      
        $product = Product::create($request->validated());
        foreach (json_decode($request->product_images) as $image) {
            ProductImage::create([
                'product_id' => $product->id,
                'image' => $image
            ]);
        }
        $product->subcategories()->attach(json_decode($request->subcategory_id));


        ResellerProduct::whereId($request->reseller_product_id)->update([
            'status' => 1,
        ]);

        return $this->sendSuccess('Added');
    }

    public function website(Request $request)
    {
        return ResellerProduct::distinct()->pluck('website');
       
    }
}
