<?php
namespace App\Services\Posts;
use App\Models\Post;

class PostService implements PostServiceInterface{

    public function getAll(){
        return Post::all();
    }
    public function createPost(array $data){
       return Post::create($data);
    }
    public function updatePost(Post $post,array $data){
        return $post->update($data);
    }
    public function deletePost(Post $post){
        return $post->delete();
    }
}