<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class CategoryController extends Controller
{use App\Http\Requests\StoreCategoryRequest;
use App\Http\Requests\UpdateCategoryRequest;
use App\Http\Resources\CategoryResource;
use App\Models\Category;
    public function index()
        {
            return CategoryResource::collection(Category::all());
        }

public function store(StoreCategoryRequest $request)
        {
            $category = Category::create($request->validated());
            return new CategoryResource($category);
        }

public function show(Category $category)
        {
            return new CategoryResource($category);
        }

public function update(UpdateCategoryRequest $request, Category $category)
        {
            $category->update($request->validated());
            return new CategoryResource($category);
        }

public function destroy(Category $category)
        {
            $category->delete();
            return response()->json(null, 204);
        }
}
