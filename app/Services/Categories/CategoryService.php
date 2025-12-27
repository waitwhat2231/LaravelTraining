<?php


namespace App\Services\Categories;

use App\Http\Resources\CategoryResource;
use App\Models\Category;
use App\Services\Categories\CategoryServiceInterface;
use Illuminate\Database\Eloquent\Collection;

class CategoryService implements CategoryServiceInterface{
        public function getAll(){
            $categories = Category::all();
            return new Collection(CategoryResource::collection($categories));
        }
        public function getAllWithPosts(){
            $categories = Category::with('posts')->get();
            return new Collection(CategoryResource::collection($categories));
        }
    public function createCategory(string $name){
        $category  = Category::create($name);
        return new CategoryResource($category);
    }
    public function updateCategory(Category $category,array $data){
        $category->update($data);
        return new CategoryResource($category);
    }
    public function deleteCategory(Category $category){
        $category->delete();
    }
}