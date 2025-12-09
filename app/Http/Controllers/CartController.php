<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Services\CartService;
use Illuminate\Http\Request;

class CartController extends Controller
{
    public function index(CartService $cart)
    {
        return view('cart.index', [
            'items' => $cart->get(),
            'subtotal' => $cart->subtotal(),
            'total' => $cart->total(),
        ]);
    }

    public function add(Product $product, CartService $cart)
    {
        $cart->add($product, 1);
        return back()->with('success', 'Added to cart');
    }

    public function update(Request $request, CartService $cart)
    {
        $request->validate([
            'product_id' => 'required|integer',
            'quantity' => 'required|integer|min:0',
        ]);

        $cart->update($request->product_id, $request->quantity);
        return back()->with('success', 'Cart updated');
    }

    public function clear(CartService $cart)
    {
        $cart->clear();
        return back();
    }
}

