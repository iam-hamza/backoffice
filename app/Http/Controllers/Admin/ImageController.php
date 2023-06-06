<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Storage;

class ImageController extends Controller
{
    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'type' => 'required',
            'images' => 'nullable|array',
            'images.*' => 'image|max:2048',
        ]);
        $imagePaths = [];
        if ($request->hasFile('images')) {
            foreach ($request->images as $image) {
                $path = Storage::disk('s3')->put($request->type, $image);
                $imagePaths[] = Storage::disk('s3')->url($path);   
            }
        }

        return $imagePaths;
    }
}
