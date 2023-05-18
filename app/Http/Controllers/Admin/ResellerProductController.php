<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\ResellerProduct;
use Illuminate\Http\Request;

class ResellerProductController extends Controller
{
    public function index(Request $request)
    {
        
        return ResellerProduct::where('status',0)->when($request->has('website'),function($q) use($request){
            $q->where('website',$request->website);
        })->paginate($request->per_page)->withQueryString();
    }
}
