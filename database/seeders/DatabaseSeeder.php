<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Author;
use App\Models\Category;
use App\Models\Post;

class DatabaseSeeder extends Seeder
{
    use WithoutModelEvents;

    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // User::factory(10)->create();

        // User::factory()->create([
        //     'name' => 'Test User',
        //     'email' => 'test@example.com',
        // ]);
        $authors = Author::factory(5)->create();
          $categories = Category::factory(5)->create();
          $posts = Post::factory(20)->make()->each(function ($post) use ($authors, $categories) {
            $post->author_id = $authors->random()->id;
            $post->category_id = $categories->random()->id;
            $post->save();
            });
    }
}
