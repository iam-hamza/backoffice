<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\AppBaseController;
use App\Models\SubCategory;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class SubCategoryController extends AppBaseController
{
    public function index(Request $request)
    {
        $subCategories = SubCategory::where('category_id',$request->category_id)->get();

        return $subCategories;
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|unique:sub_categories',
            'category_id' => 'nullable|exists:categories,id',
        ]);

        $subCategory =  SubCategory::create($request->all());

        return SubCategory::where('category_id',$subCategory->category_id)->get();
        
    }

    public function update(Request $request, SubCategory $subcategory)
    {
        $request->validate([
            'name' => 'required|unique:sub_categories,name,' . $subcategory->id,
            'category_id' => 'nullable|exists:categories,id',
        ]);

        $subcategory->update($request->all());

        return SubCategory::where('category_id',$subcategory->category_id)->get();
    }

    public function show($subcategory)
    {
        return SubCategory::findOrFail($subcategory);
    }

    // public function destroy(SubCategory $subcategory)
    // {
    //     $subcategory->delete();

    //     return ;
    // }
}
