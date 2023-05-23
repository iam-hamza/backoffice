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
        $banners = Banner::where('banner_type',$request->type)->first();

       return BannersResource::make($banners);
    }

    public function store(CreateBannerRequest $request)
    {
        $input = $request->validated();
        $path = Storage::disk('s3')->put('banner', $request->image);
        $input['image'] = Storage::disk('s3')->url($path);    
        Banner::create($input);

        return $this->sendSuccess('Added');
    }

    public function update(UpdateBannerRequest $request, Banner $banner)
    {
        $input = $request->validated();
        $path = Storage::disk('s3')->put('banner', $request->image);
        $input['image'] = Storage::disk('s3')->url($path);   
        $banner->update($input);

        return $this->sendSuccess('Updated');
    }

    public function destroy( Banner $banner)
    {
        $banner->delete();

        return $this->sendSuccess('Deleted');
    }
}
