<?php

namespace Database\Seeders;

use App\Models\Author;
use App\Models\Post;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class AuthorSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        Author::factory(1000)
        ->has(Post::factory(3), 'posts')
        ->create();
    }
}