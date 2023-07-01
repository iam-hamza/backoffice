<?php

namespace App\Http\Controllers\MobileApp;

use App\Models\Product;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Resources\ProductResource;

class ProductController extends Controller
{
    public function index(Request $request)
    {
        $products =  Product::when($request->has('name'),function($q) use($request){
            $q->where('name', 'LIKE', '%' . $request->name . '%');
            $q->orWhere('sku', 'LIKE', '%' . $request->name . '%');
        })
        ->when($request->has('brand'),function($q) use($request){
            $q->where('brand',$request->brand);
        })
        ->when($request->has('type'),function($q) use($request){
            $q->whereHas('category', function($q) use($request){
                $q->where('type', $request->type);
            })
            ->when($request->has('category'),function($q) use($request){
                $q->where('category_id',$request->category);
            })
            ->when($request->has('subcategory'),function($q) use($request){
                $q->whereHas('subcategories', function($q) use($request){
                    $q->where('sub_category_id', $request->subcategory);
                });
            });
        })
        ->where('status',1)
        ->with(['images','subcategories','category'])
        ->paginate($request->per_page)
        ->withQueryString();

        return ProductResource::collection($products);
        
    }
}
