<?php

namespace Database\Seeders;

use App\Models\Post;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class PostSeeder extends Seeder
{
    public function run(): void
    {
        $posts = [
            [
                'title' => 'Welcome to my portfolio',
                'excerpt' => 'A quick intro to this site and what you can expect to find here.',
                'body' => "Welcome! This is where I'll be sharing notes on projects I'm building, things I'm learning, and the occasional write-up on Laravel and web development.\n\nStay tuned for more posts.",
                'is_published' => true,
                'published_at' => now(),
            ],
        ];

        foreach ($posts as $post) {
            Post::updateOrCreate(
                ['slug' => Str::slug($post['title'])],
                $post + ['slug' => Str::slug($post['title'])]
            );
        }
    }
}
