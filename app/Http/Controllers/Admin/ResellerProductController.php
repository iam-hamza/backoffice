<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\AppBaseController;
use App\Http\Controllers\Controller;
use App\Http\Resources\ResellerProducrReseource;
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
        })
        ->paginate($request->per_page)->withQueryString();

        return ResellerProducrReseource::collection($product);
    }


    public function categories(Request $request)
    {
        
        return ResellerCategory::where('website',$request->website)->get();
    }

    public function addToProduct(Request $request)
    {
        
        ResellerProduct::whereId($request->id)->update([
            'status' => 1,
        ]);

        return $this->sendSuccess('Added');
    }
}
