<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Tag;
use Yajra\DataTables\Datatables;
use Illuminate\Http\Request;
use Illuminate\Support\Str;


class TagController extends Controller
{

    public function index()
    {
        return view('admin.tags.index', [
            'page' => 'Tags'
        ]);
    }


    public function create()
    {
        //
    }


    public function store(Request $request)
    {
        $data = [
            'name' => $request['name'],
            'slug' => Str::slug(request('name')),
            'created_at' => date('Y-m-d H:i:s'),

        ];

        return Tag::create($data);
    }


    public function show($id)
    {
        //
    }


    public function edit(Tag $tag)
    {
        return Tag::find($tag->id);
    }


    public function update(Request $request, Tag $tag)
    {
        $tag = Tag::find($tag->id);
        $tag->name = $request['name'];
        $tag->slug = Str::slug($request['name']);
        $tag->updated_at = date("Y-m-d H:i:s");
        $tag->update();

        return $tag;
    }


    public function destroy(Tag $tag)
    {
        Tag::destroy($tag->id);
    }

    public function api_tag()
    {
        $tag = Tag::all();
        return Datatables::of($tag)
            ->addIndexColumn()
            ->addColumn('action', function($tag) {
                return '<a onclick="editForm(' . $tag->id . ')" class="btn btn-primary btn-xs"><i class ="glyphicon glyphicon-edit"></i> Edit</a> ' .
                    '<a onclick="deleteData(' . $tag->id . ')" class="btn btn-danger btn-xs"><i class ="glyphicon glyphicon-trash"></i> Delete</a> ';
            })
            ->rawColumns(['action'])->make(true);
    }

}
