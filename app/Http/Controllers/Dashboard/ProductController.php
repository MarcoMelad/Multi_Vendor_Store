<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use App\Models\Product;
use App\Models\Tag;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class ProductController extends Controller
{

    public function index()
    {
        $products = Product::with(['category', 'store'])->paginate();
        return view('dashboard.products.index',compact('products'));
    }


    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    public function edit($id)
    {
        $product = Product::findOrFail($id);
        $tags = implode(',',$product->tags()->pluck('name')->toArray());
        return view('dashboard.products.edit',compact('product', 'tags'));
    }


    public function update(Request $request, Product $product)
    {
        $product->update($request->except('tags'));

        $tags = json_decode($request->post('tags'));
        $tags_ids = [];

        $saved_tags = Tag::all();
        foreach ($tags as $item){
            $slug = Str::slug($item->value);
            $tag =  $saved_tags->where('slug', $slug)->first();
            if (!$tag) {
                $tag = Tag::create([
                    'name' => $item->value,
                    'slug' => $slug
                ]);
            }
            $tags_ids[] = $tag->id;
        }
        $product->tags()->sync($tags_ids);

        return redirect()->route('products.index')->with('success','Product Updated');
    }

    public function destroy(Product $product)
    {
        $product->delete();
    }
}
