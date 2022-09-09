<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use App\Models\Post;
use App\Models\Category;
use App\Models\Tag;


class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        User::factory(10)->create();
        User::create([
            'name' => 'Dicky Kamaludin Bashar',
            'email' => 'dicky@gmail.com',
            'password' => bcrypt('123456'),
            'created_at' => date("Y-m-d H:i:s"),
            'updated_at' => date("Y-m-d H:i:s"),
        ]);


        Category::create([
            'name' => 'Web Programming',
            'slug' => 'web-programming'
        ]);

        Category::create([
            'name' => 'Programming',
            'slug' => 'programming'
        ]);

        Category::create([
            'name' => 'Web Design',
            'slug' => 'web-design'
        ]);

        Category::create([
            'name' => 'Design',
            'slug' => 'design'
        ]);

        Category::create([
            'name' => 'Computer',
            'slug' => 'computer'
        ]);

        Tag::create([
            'name' => 'PHP',
            'slug' => 'php'
        ]);

        Tag::create([
            'name' => 'Laravel',
            'slug' => 'laravel'
        ]);

        Tag::create([
            'name' => 'Back end',
            'slug' => 'back-end'
        ]);

        Tag::create([
            'name' => 'JavaScript',
            'slug' => 'javascript'
        ]);

        Tag::create([
            'name' => 'React JS',
            'slug' => 'react-js'
        ]);

        Tag::create([
            'name' => 'Front end',
            'slug' => 'front-end'
        ]);


        for ($i=1; $i <= 20 ; $i++) { 
            $post = Post::factory()->create();
            $post->tags()->sync([mt_rand(1, 5), mt_rand(1, 5)]);
        }


    }
}
