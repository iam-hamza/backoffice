<?php

namespace App\Http\Controllers\MobileApp;

use App\Http\Controllers\AppBaseController;
use App\Models\Banner;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Resources\MobileApp\BannerResource;
use DB;

class BannersController extends AppBaseController
{
    public function  index(Request $request)
    {
        $type = $request->type;
       $banners = Banner::when($type,function($q) use($type){
            
            $q->where('banner_type',$type);
        })->get();

        if (count($banners)>0) {
            return BannerResource::collection($banners);
        } else {
            return $this->sendError('No Banner Found',404);
        }
       
        
    }
}
