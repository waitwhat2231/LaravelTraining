<?php
namespace App\Services\Posts;
use App\Models\Post;

interface PostServiceInterface{
    public function getAll();
    public function createPost(array $data);
    public function updatePost(Post $post,array $data);
    public function deletePost(Post $post);
}