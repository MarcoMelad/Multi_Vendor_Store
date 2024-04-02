<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use App\Http\Requests\CategoryRequest;
use App\Models\Category;
use Illuminate\Support\Facades\Request;
use Illuminate\Support\Str;
use Mockery\Exception;

class CategoriesController extends Controller
{

    public function index()
    {
        $request = request();


        //$categories = Category::active()->paginate(5);
        //$categories = Category::status('archived')->paginate(5);
        $categories = Category::with('parent')/*leftJoin('categories as parents', 'parents.id', '=', 'categories.parent_id')
            ->select([
                'categories.*',
                'parents.name as parent_name'
            ])*/
        ->withCount([
            'products' => function ($query) {
                $query->where('status','=','active');
            }
        ])
            ->filter($request->query())->paginate(10);
        return view('dashboard.categories.index', compact('categories'));
    }


    public function show(Category $category)
    {
        return view('dashboard.categories.show',[
            'category' => $category
        ]);
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
            $image->storeAs('public/images', $imageName, 'upload_attachments');
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
        try {
            $category = Category::findOrFail($id);
        } catch (\Exception $e) {
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


    public function destroy(Category $category)
    {
        //Category::findOrFail($id)->delete();
        $category->delete();
        return redirect()->route('categories.index')->with('success', 'Category Deleted Successfully!');
    }

    public function trash()
    {
        $categories = Category::onlyTrashed()->paginate();
        return view('dashboard.categories.trash', compact('categories'));
    }

    public function restore(Request $request, $id)
    {
        $category = Category::onlyTrashed()->findOrFail($id);
        $category->restore();

        return redirect()->route('categories.trash')->with('success', 'Category Restored Successfully!');
    }

    public function forceDelete($id)
    {
        $category = Category::onlyTrashed()->findOrFail($id);
        $category->forceDelete();

        return redirect()->route('categories.trash')->with('success', 'Category Deleted Permanently!');
    }
}
