<?php


namespace App\Services\Categories;

use App\Models\Category;

interface CategoryServiceInterface{
    public function getAll();
    public function getAllWithPosts();
    public function createCategory(string $name);
    public function updateCategory(Category $category,array $data);
     public function deleteCategory(Category $category);
}