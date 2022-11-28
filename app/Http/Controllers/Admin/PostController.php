<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use App\Models\{Category, Tag, Post};
use Yajra\DataTables\Datatables;

class PostController extends Controller
{

    public function index()
    {
        return view('admin.posts.index', [
            'page' => 'Posts'
        ]);
    }


    public function create()
    {
        $category = Category::get();
        $tag = Tag::get();

        return view('admin.posts.create', [
            'categories' => $category,
            'tags' => $tag,
            'post' => new Post,
            'page' => 'Add a post'
        ]);
    }


    public function store()
    {
        if (request()->file('image') == null) {
            $image = null;
        } else {
            $image = request()->file('image')->store('images/post');
        }

        request()->validate([
            'title' => 'required',
            'post' => 'required',
            'image' => 'nullable|image|mimes:jpeg,png,gif',
            'tags' => 'required|array',
            'category_id' => 'required'
        ]);

        $post = Post::create([
            'title' => request('title'),
            'post' => request('post'),
            'slug' => Str::slug(request('title')),
            'image' => $image,
            'user_id' => auth()->user()->id,
            'category_id' => request('category_id'),
            'created_at' => date("Y-m-d H:i:s"),
            'updated_at' => date("Y-m-d H:i:s")
        ]);

        $post->tags()->sync(request('tags'));

        return redirect('admin/posts')->with('success', 'Post has been created');
    }


    public function show($id)
    {
        //
    }


    public function edit(Post $post)
    {
        $category = Category::get();
        $tag = Tag::get();
        // $post = Post::find($post->id);

        return view('admin.posts.edit', [
            'categories' => $category,
            'tags' => $tag,
            'post' => $post,
            'page' => 'Edit post'
        ]);
    }


    public function update(Post $post)
    {
        request()->validate([
            'title' => 'required',
            'post' => 'required',
            'image' => 'nullable|image|mimes:jpeg,png,gif',
            'tags' => 'required|array',
            'category_id' => 'required'
        ]);

        if (request('image')) {
            Storage::delete($post->image);
            $image = request()->file('image')->store('images/post');
        } else if ($post->image) {
            $image = $post->image;
        } else {
            $image = null;
        }

        $post->update([
            'title' => request('title'),
            'post' => request('post'),
            'image' => $image,
            'user_id' => auth()->user()->id,
            'category_id' => request('category_id'),
            'updated_at' => date("Y-m-d H:i:s")
        ]);


        $post->tags()->sync(request('tags'));

        return redirect('admin/posts')->with('success', 'Post has been updated');
    }

    public function destroy(Post $post)
    {
        if ($post->image) {
            Storage::delete($post->image);
        }
        $post->tags()->detach();
        $post->delete();
        return redirect('admin/posts')->with('success', 'Post has been deleted');
    }

    public function api_post()
    {
        $post = Post::with('category')->get();
        return Datatables::of($post)
            ->addIndexColumn()
            ->addColumn('category', function ($post) {
                return $post->category->name;
            })
            ->addColumn('action', function ($post) {
                return '<a href="' .  route("posts.edit", $post->id)  . '" class="btn btn-primary btn-xs"><i class ="glyphicon glyphicon-edit"></i> Edit</a> ' .
                    '<a onclick="deleteData(' . $post->id . ')" class="btn btn-danger btn-xs"><i class ="glyphicon glyphicon-trash"></i> Delete</a> ';
            })
            ->rawColumns(['action'])->make(true);
    }
}
