<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\ProductrResource;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ProductsController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth:sanctum')->except(['index', 'show']);
    }
    public function index(Request $request)
    {
        $product = product::filter($request->query())->with('category:id,name','store:id,name','tags:id,name')->paginate();
        return ProductrResource::collection($product);
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

        $user = $request->user();
        if (!$user->tokenCan('products.create')){
            return response()->json([
                'message' => 'Unauthorized'
            ],403);
        };

        $product = Product::create($request->all());
        return response()->json($product,201);
    }

    public function show(Product $product)
    {
        return new ProductrResource($product);
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

        $user = $request->user();
        if (!$user->tokenCan('products.update')){
            return response()->json([
                'message' => 'Unauthorized'
            ],403);
        };

        $product->update($request->all());
        return response()->json($product);
    }

    public function destroy($id)
    {
        $user = Auth::user();
        if (!$user->tokenCan('products.delete')){
            return response()->json([
                'message' => 'Unauthorized'
            ],403);
        };
        Product::destroy($id);
        return [
            'message' => 'Product deleted successfully'
        ];
    }
}
