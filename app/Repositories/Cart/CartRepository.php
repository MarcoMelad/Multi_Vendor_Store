<?php

namespace App\Repositories\Cart;

use App\Models\Cart;
use App\Models\Product;
use App\Repositories\Cart\CartRepositoryInterface;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Cookie;
use Illuminate\Support\Str;
use Illuminate\Support\Collection;

class CartRepository implements CartRepositoryInterface
{

    public function get(CartRepositoryInterface $cartRepository)
    {
        $cart = Cart::with('product')->where('cookie_id', $this->getCookieId())->get();
        return view('front.cart',compact('cart', 'cartRepository'));
    }

    public function add(Product $product, $quantity = 1)
    {
        $item = Cart::where('product_id', $product->id)->where('cookie_id', $this->getCookieId())->first();
        if (!$item) {
            Cart::create([
                'cookie_id' => $this->getCookieId(),
                'user_id' => Auth::id(),
                'product_id' => $product->id,
                'quantity' => $quantity,
            ]);
        }
        $item->increment('quantity', $quantity);
        return redirect()->route('cart.index')->with('success', 'Product Added To Cart!');
    }

    public function update(Product $product, $quantity)
    {
        Cart::where('product_id', $product->id)->where('cookie_id', $this->getCookieId())
            ->update([
                'quantity' => $quantity
            ]);
    }

    public function delete($id)
    {
        Cart::where('id', $id)
            ->where('cookie_id', $this->getCookieId())->delete();
    }

    public function empty()
    {
        Cart::where('cookie_id', $this->getCookieId())->destroy();
    }

    public function total(): float
    {
        return (float)Cart::where('cookie_id', $this->getCookieId())->join('products', 'products.id', '=', 'carts.product_id')
            ->selectRaw('SUM(products.price * carts.quantity) as total')->value('total');
    }

    protected function getCookieId()
    {
        $cookie_id = Cookie::get('cart_id');
        if (!$cookie_id) {
            $cookie_id = Str::uuid();
            Cookie::queue('cart_id', $cookie_id, 30 * 24 * 60);
        }
        return $cookie_id;
    }
}
