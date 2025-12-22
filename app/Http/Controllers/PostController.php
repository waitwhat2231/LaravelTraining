<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests\StorePostRequest;
use App\Models\Post;

class PostController extends Controller
{
    public function index()
    {
        $posts = Post::all();
        return response()->json([
            'success'=>true,
            'data'=>$posts
        ]);
    }
    public function store(StorePostRequest $request){
        Post::Create($request->validated());
        return response()->json([
            'sucess'=>true,

        ]);
    }

    public function show(Post $post){
       return response()->json($post);
    }

    public function update(Request $request,Post $post){
           $validated = $request->validate([
        'title'       => 'sometimes|required|string',
        'content'     => 'sometimes|required|string',
        'category_id' => 'sometimes|required|exists:categories,id',
    ]);
    $post->update($validated);
    return response()->json([
        'success'=>true,
        'data'=>$post
    ]);
    }
    public function destroy(Post $post){
        $post->delete();
        return response()->json(['success'=>true,]);
    }

    
}
