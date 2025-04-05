<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Post;
use App\Models\Category;

class PostsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $categories = Category::all();

        foreach (range(1, 10000) as $index) {
            $post = Post::create([
                'title'   => "Bài viết $index",
                'content' => "Nội dung của bài viết $index.",
                'views'   => rand(0, 1000),
            ]);

            $randomCategories = $categories->random(rand(1, 5))->pluck('id');
            $post->categories()->attach($randomCategories);
        }
    }
}
