<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Post;
use App\Models\Category;

use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function index()
    {
        $page = 'Dashboard';

        if (request('category')) {
            $category = Category::firstWhere('slug', request('category'));
        }

        $posts = Post::with('tags', 'category', 'user')->latest()->filter(request(['search', 'category', 'author', 'tag']))->paginate(12)->withQueryString();

        return view('admin.dashboard.index', compact('posts', 'page'));
    }

    public function show(Post $post)
    {
        $page = 'Detail Post';

        return view('admin.dashboard.show', compact('post', 'page'));
    }
}
