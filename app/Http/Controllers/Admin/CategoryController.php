<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\AppBaseController;
use App\Http\Controllers\Controller;
use Throwable;
use App\Models\Category;
use App\Models\Product;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use Illuminate\Http\Client\HttpClientException;
use Illuminate\Support\Facades\Storage;


class CategoryController extends AppBaseController
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
            $categories = Category::with('subCategory')->get();


            return $this->sendSuccess(
                $categories,Response::$statusTexts[Response::HTTP_FOUND],
                Response::HTTP_OK
            );
          
        
    }
    /**
     * Display a single of the resource.
     */
    public function show(Category $category)
    {
        
            return $category;
        
    }

    public function store(Request $request)
    {
        // Validate the form data
        $validatedData = $request->validate([
            'name' => 'required|string|unique:categories',
            'image' => 'image|max:2048',
            'description' => 'nullable|string',
        ]);

        // Handle image upload
        if ($request->hasFile('image')) {
            $path = Storage::disk('s3')->put('category', $request->image);
            $validatedData['image'] = Storage::disk('s3')->url($path);   
        }
    
        // Create a new instance of your model with the validated data
        $category = Category::create($validatedData);


        // Return a success response or redirect
        return $category;
    }

    public function update(Request $request, $id)
    {
        // Validate the form data
        $validatedData = $request->validate([
            'name' => 'required|string|unique:categories,name,' . $id,
            'image' => 'nullable|image|max:2048',
            'description' => 'nullable|string',
        ]);

        // Find the product by ID
        $category = Category::findOrFail($id);

        // Handle image upload
        if ($request->hasFile('image')) {
            
                $path = Storage::disk('s3')->put('category', $request->image);
                $validatedData['image'] = Storage::disk('s3')->url($path);   
        }

        // Update the category with the validated data
        $category->update($validatedData);

        // Return a success response or redirect
        return Category::findOrFail($id);
    }

    public function destroy($id)
    {
        if(Product::where('category_id',$id)->exists()){
            return $this->sendError('Category in Use');
        }
        $category = Category::findOrFail($id);
        $category->delete();

        return $this->sendSuccess('Deleted');

    }

}
