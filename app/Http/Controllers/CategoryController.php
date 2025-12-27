<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreCategoryRequest;
use App\Http\Requests\UpdateCategoryRequest;
use App\Http\Resources\CategoryResource;
use Illuminate\Http\Request;
use App\Models\Category;
use App\Services\Categories\CategoryServiceInterface;

class CategoryController extends Controller
{
    public function __construct(private CategoryServiceInterface $categoryService){}
    public function index(){
      return $this->categoryService->getAll();
    }

    public function show(Category $category){
        return new CategoryResource($category->load('posts'));
    }
    public function store(StoreCategoryRequest $request){
        $category = $this->categoryService->createCategory($request->validated()['name']);
        return $category;
    }
    public function update(UpdateCategoryRequest $request, Category $category){
        
        return $this->categoryService->updateCategory($category,$request->validated());
    }
    public function destroy(Category $category){
        $category->delete();
        return response()->json(["message"=> "Delete Successful"]);
    }
    public function showWithPosts(){
        $categories = Category::with('posts')->get();
        return response()->json($categories);
    }

}
