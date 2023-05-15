<?php

namespace App\Http\Controllers\Traits\Product;

use Illuminate\Support\Facades\Storage;

trait ProductTrait
{

    public function multipleImagesUpload($images)
    {
        $fileNames = [];
        foreach ($images ?? [] as $key => $image) {
            $time = time();
            $fileName = "{$key}_product_{$time}.{$image->extension()}";
            Storage::disk('public')->put("product/{$fileName}",file_get_contents($image));
            $fileNames[] = "storage/product/{$fileName}";
        }
        return $fileNames;
    }
}