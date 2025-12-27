<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class CategoryResource extends JsonResource
{
    protected bool $getPosts = false;
      public function __construct($resource, bool $getPosts = false)
    {
        parent::__construct($resource);
        $this->getPosts = $getPosts;
    }
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
       return [
        'id'=>$this->id,
        'name'=>$this->name,
        'posts'=>$this->getPosts?optional($this->posts):null,
       ];

    }
}
