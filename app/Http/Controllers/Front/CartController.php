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
        return $this->cartRepository->get($this->cartRepository);
    }

    public function store(Request $request)
    {
        $request->validate([
            'product_id' => 'required|int|exists:products,id',
            'quantity' => 'nullable|int|min:1'
        ]);

        $product = Product::findOrFail($request->post('product_id'));
        return $this->cartRepository->add($product,$request->post('quantity'));
    }



    public function update(Request $request, $id)
    {
        $request->validate([
            'product_id' => 'required|int|exists:products,id',
            'quantity' => 'nullable|int|min:1'
        ]);

        $product = Product::findOrFail($request->post('product_id'));
        return $this->cartRepository->update($product,$request->post('quantity'));
    }


    public function destroy($id)
    {
        return $this->cartRepository->delete($id);
    }

}
