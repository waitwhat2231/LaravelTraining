<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class PostResource extends JsonResource
{
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
            'author'      => [
                'id'   => $this->author->id ?? null,
                'name' => $this->author->name ?? null,
            ],
            'category'=>[
                'id'=>$this->category_id??null,
                'name'=>$this->category->name ?? null,
            ]
        ];
    }
}
