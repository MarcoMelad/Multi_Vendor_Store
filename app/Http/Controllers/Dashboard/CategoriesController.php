<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class CategoriesController extends Controller
{

    public function index()
    {
        $categories = Category::all();
        return view('dashboard.categories.index', compact('categories'));
    }


    public function create()
    {
        $parents = Category::all();
        return view('dashboard.categories.creat',compact('parents'));
    }


    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|max:255',
            'status' => 'required'
        ]);

        $request->merge([
            'slug' => Str::slug($request->name)
        ]);

        $category = Category::create($request->all());

        return redirect()->route('categories.index')->with('success', 'Category Created Successfully!');

    }

    public function show($id)
    {
        //
    }


    public function edit($id)
    {
        //
    }


    public function update(Request $request, $id)
    {
        //
    }


    public function destroy($id)
    {
        //
    }
}
