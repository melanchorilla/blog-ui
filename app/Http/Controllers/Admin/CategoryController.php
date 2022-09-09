<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Category;
use Yajra\DataTables\Datatables;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class CategoryController extends Controller
{
    public function index()
    {
        return view('admin.categories.index', [
            'page' => 'Categories'
        ]);
    }

    public function create(){

    }

    public function store(Request $request)
    {
        $data = [
            'name' => $request['name'],
            'slug' => Str::slug(request('name')),
            'created_at' => date('Y-m-d H:i:s'),

        ];

        return Category::create($data);
    }

    public function show(){

    }

    public function edit(Category $category){
        return Category::find($category->id);
    }

    public function update(Request $request, Category $category){
        $category = Category::find($category->id);
        $category->name = $request['name'];
        $category->slug = Str::slug($request['name']);
        $category->updated_at = date("Y-m-d H:i:s");
        $category->update();

        return $category;
    }

    public function destroy(Category $category){
        Category::destroy($category->id);
    }

    public function api_category()
    {
        $category = Category::all();
        return Datatables::of($category)
            ->addIndexColumn()
            ->addColumn('action', function($category) {
                return '<a onclick="editForm(' . $category->id . ')" class="btn btn-primary btn-xs"><i class ="glyphicon glyphicon-edit"></i> Edit</a> ' .
                    '<a onclick="deleteData(' . $category->id . ')" class="btn btn-danger btn-xs"><i class ="glyphicon glyphicon-trash"></i> Delete</a> ';
            })
            ->rawColumns(['action'])->make(true);
    }
}
