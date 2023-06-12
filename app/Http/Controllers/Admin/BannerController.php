<?php

namespace App\Http\Controllers\Admin;

use Storage;
use App\Models\Banner;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Requests\CreateBannerRequest;
use App\Http\Requests\UpdateBannerRequest;
use App\Http\Controllers\AppBaseController;
use App\Http\Resources\BannersResource;

class BannerController extends AppBaseController
{
    public function index(Request $request)
    {
        $banners = Banner::where('banner_type',$request->type)->get();
       
       return BannersResource::collection($banners);
    }

    public function store(CreateBannerRequest $request)
    {
        $input = $request->validated();
        $path = Storage::disk('s3')->put('banner', $request->image);
        $input['image'] = Storage::disk('s3')->url($path);    
        $banner = Banner::create($input);

        return $banner;
    }

    public function update(UpdateBannerRequest $request, Banner $banner)
    {
        $input = $request->validated();
        $path = Storage::disk('s3')->put('banner', $request->image);
        $input['image'] = Storage::disk('s3')->url($path);   
        $banner->update($input);

        return $this->show($banner->id);
    }

    public function destroy( Banner $banner)
    {
        $banner->delete();

        return $this->sendSuccess('Deleted');
    }

    public function show($id)
    {
        return Banner::findOrFail($id);
    }
}
