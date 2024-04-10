<?php

namespace App\Listeners;

use App\Facades\Cart;
use App\Models\Product;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Support\Facades\DB;

class DeductProductQuantity
{
    /**
     * Create the event listener.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    public function handle()
    {
        foreach (Cart::get() as $item){
            Product::where('id', $item->product_id)->update([
                'quantity' => DB::raw("quantity - {$item->quantity}")
            ]);
        }
    }
}
