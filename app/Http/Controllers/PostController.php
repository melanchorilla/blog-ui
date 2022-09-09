<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Post;
use Illuminate\Http\Request;
// use Illuminate\Support\Str;


class PostController extends Controller
{

    public function index()
    {
        if (request('category')) {
            $category = Category::firstWhere('slug', request('category'));
        }

        $categories = Category::all();
        $posts = Post::with('tags', 'category', 'user')->latest()->filter(request(['search', 'category', 'author', 'tag']))->paginate(5)->withQueryString();

        return view('posts.index', compact('posts', 'categories'));
    }

    public function show(Post $post)
    {
        return view('posts.show', compact('post'));
    }
    
}
