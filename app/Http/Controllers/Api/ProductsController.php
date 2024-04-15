<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
class ProductsController extends Controller
{

    public function index(Request $request)
    {
        return product::filter($request->query())->with('category:id,name','store:id,name','tags:id,name')->paginate();
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string|max:255',
            'category_id' => 'required|integer|exists:categories,id',
            'status' => 'in:active,inactive',
            'price' => 'required|numeric|min:0',
            'compare_price' => 'nullable|numeric|greater:price',
        ]);

        $product = Product::create($request->all());
        return response()->json($product,201);
    }

    public function show(Product $product)
    {
        return $product->load('category:id,name','store:id,name','tags:id,name');
    }

    public function update(Request $request, Product $product)
    {
        $request->validate([
            'name' => 'sometimes|required|string|max:255',
            'description' => 'nullable|string|max:255',
            'category_id' => 'sometimes|required|integer|exists:categories,id',
            'status' => 'in:active,inactive',
            'price' => 'sometimes|required|numeric|min:0',
            'compare_price' => 'nullable|numeric|greater:price',
        ]);
        $product->update($request->all());
        return response()->json($product);
    }

    public function destroy($id)
    {
        Product::destroy($id);
        return [
            'message' => 'Product deleted successfully'
        ];
    }
}
