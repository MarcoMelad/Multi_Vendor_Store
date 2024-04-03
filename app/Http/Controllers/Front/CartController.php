<?php

namespace App\Http\Controllers\Front;

use App\Http\Controllers\Controller;
use App\Models\Product;
use App\Repositories\Cart\CartRepositoryInterface;
use Illuminate\Http\Request;

class CartController extends Controller
{
    public $cartRepository;

    public function __construct(CartRepositoryInterface $cartRepository)
    {
        $this->cartRepository = $cartRepository;
    }

    public function index()
    {
        return view('front.cart', [
            'cart' => $this->cartRepository,
        ]);
    }

    public function show()
    {

    }

    public function store(Request $request)
    {
        $request->validate([
            'product_id' => 'required|int|exists:products,id',
            'quantity' => 'nullable|int|min:1'
        ]);

        $product = Product::findOrFail($request->post('product_id'));
        $this->cartRepository->add($product, $request->post('quantity'));
        return redirect()->route('cart.index')->with('success', 'Product Added To Cart!');
    }


    public function update(Request $request, $id)
    {
        $request->validate([
            'quantity' => 'required|int|min:1'
        ]);

        $this->cartRepository->update($id, $request->post('quantity'));
    }


    public function destroy($id)
    {
        $this->cartRepository->delete($id);
        return [
            'message' => 'Product Deleted!'
        ];
    }

}
