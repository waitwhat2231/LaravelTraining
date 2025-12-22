<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Author extends Model
{
    use HasFactory;
    Protected $fillable=[
        'email',
    ];
    public function posts(){
        return $this->hasMany(Post::Class);
    }
}
