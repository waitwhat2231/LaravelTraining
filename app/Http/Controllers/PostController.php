<?php

namespace App\Http\Controllers;

use App\Http\Requests\UpdatePostRequest;
use App\Http\Resources\PostResource;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Http\Request;
use App\Http\Requests\StorePostRequest;
use App\Models\Post;
use App\Services\Posts\PostServiceInterface;

class PostController extends Controller
{
       public function __construct(
        private PostServiceInterface $postService
    ) {}
    public function index()
    {
        $posts = $this->postService->getAll();
        return response()->json([
            'success'=>true,
            'data'=>new Collection(PostResource::collection($posts)),
        ],200);
    }
    public function store(StorePostRequest $request){
        $validated= $request->validated();
        $validated['author_id']=auth()->user()->id;
        $post = $this->postService->createPost($validated);
        return response()->json([
            'sucess'=>true,
            'data'=>new PostResource($post),
        ],201);
    }

    public function show(Post $post){
       return new PostResource($post,true,true);
    }

    public function update(UpdatePostRequest $request,Post $post){
    $validated = $request->validated();
    $updated_post=$this->postService->updatePost($post,$validated);
    return response()->json([
        'success'=>true,
        'data'=>new PostResource($updated_post)
    ],204);
    }
    public function destroy(Post $post){
        $this->postService->deletePost($post);
        return response()->json(['success'=>true,],204);
    }

    
}
