<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use App\Http\Requests\CategoryRequest;
use App\Models\Category;
use Illuminate\Support\Str;
use Mockery\Exception;

class CategoriesController extends Controller
{

    public function index()
    {
        $categories = Category::paginate(5);
        return view('dashboard.categories.index', compact('categories'));
    }


    public function create()
    {
        $parents = Category::all();
        return view('dashboard.categories.creat', compact('parents'));
    }


    public function store(CategoryRequest $request)
    {
        $imageName = null;
        if ($request->hasFile('image')) {
            $image = $request->file('image');
            $imageName = $image->getClientOriginalName();
            $image->storeAs('public/images', $imageName,'upload_attachments');
        }

        Category::create([
            'name' => $request->name,
            'parent_id' => $request->parent_id,
            'description' => $request->description,
            'image' => $imageName,
            'status' => $request->status,
            'slug' => Str::slug($request->name)
        ]);

        return redirect()->route('categories.index')->with('success', 'Category Created Successfully!');

    }


    public function edit($id)
    {
        try{
            $category = Category::findOrFail($id);
        }catch (\Exception $e){
            return redirect()->route('categories.index')->with('info', 'Category Not Found!');
        }
        $parents = Category::where('id', '<>', $id)
            ->where(function ($query) use ($id) {
                $query->whereNull('parent_id')->orwhere('parent_id', '<>', $id);
            })->get();

        return view('dashboard.categories.edit', compact('category', 'parents'));
    }


    public function update(CategoryRequest $request, $id)
    {
        try {
            $category = Category::findOrFail($id);
            $category->update([
                'name' => $request->name,
                'parent_id' => $request->parent_id,
                'description' => $request->description,
                'image' => $request->image,
                'status' => $request->status,
                'slug' => Str::slug($request->name)
            ]);

            return redirect()->route('categories.index')->with('success', 'Category Updated Successfully!');
        } catch (\Exception $e) {
            return back()->withError($e->getMessage());
        }
    }


    public function destroy($id)
    {
        Category::findOrFail($id)->delete();
        return redirect()->route('categories.index')->with('success', 'Category Deleted Successfully!');
    }
}
