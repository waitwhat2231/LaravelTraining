<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Category;

class CategoryController extends Controller
{
    public function index(){
        $categories = Category::all();
        return response()->json(['sucess'=>true,'data'=>$categories]);
    }

    public function show(Category $category){
        return response()->json($category);
    }
    public function store(Request $request){
        $category = Category::create($request->all());
        return response()->json($category);
    }
    public function update(Request $request, Category $category){
        $category->update($request->validate(['name'=>'string']));
        return response()->json($category);
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
