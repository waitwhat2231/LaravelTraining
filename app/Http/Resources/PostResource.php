<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class PostResource extends JsonResource
{
     protected bool $getCategory = false;
     protected bool $getAuthor = false;
      public function __construct($resource, bool $getCategory = false,bool $getAuthor = false)
    {
        parent::__construct($resource);
        $this->getCategory = $getCategory;
        $this->getAuthor = $getAuthor;
    }
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [ 
            'id'          => $this->id,
            'title'       => $this->title,
            'content'     => $this->content,
            'category_id' => $this->category_id,
            'author_id'   => $this->author_id,
            'author'      =>$this->getAuthor? [
                'id'   => $this->author->id ?? null,
                'name' => $this->author->name ?? null,
            ]:null,
            'category'=>$this->getCategory?[
                'id'=>$this->category_id??null,
                'name'=>$this->category->name ?? null,
            ]:null
        ];
    }
}
