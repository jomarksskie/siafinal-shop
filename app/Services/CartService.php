<?php

namespace App\Services;

use App\Models\Product;
use Illuminate\Support\Collection;

class CartService
{
    /**
     * Create a new class instance.
     */
     public function get(): Collection
    {
        return collect(session('cart', []));
    }

    public function add(Product $product, int $qty = 1): void
    {
        $cart = $this->get()->keyBy('product_id');

        if ($cart->has($product->id)) {
            $item = $cart[$product->id];
            $item['quantity'] += $qty;
            $cart[$product->id] = $item;
        } else {
            $cart[$product->id] = [
                'product_id' => $product->id,
                'name' => $product->name,
                'price' => (float)$product->price,
                'quantity' => $qty,
                'image_path' => $product->image_path,
            ];
        }

        session(['cart' => $cart->values()->all()]);
    }

    public function update(int $productId, int $qty): void
    {
        $cart = $this->get()->keyBy('product_id');
        if ($cart->has($productId)) {
            if ($qty <= 0) $cart->forget($productId);
            else {
                $item = $cart[$productId];
                $item['quantity'] = $qty;
                $cart[$productId] = $item;
            }
        }
        session(['cart' => $cart->values()->all()]);
    }

    public function clear(): void
    {
        session()->forget('cart');
    }

    public function subtotal(): float
    {
        return $this->get()->sum(fn($i) => $i['price'] * $i['quantity']);
    }

    public function total(): float
    {
        return $this->subtotal(); // add shipping/tax later if needed
    }
}
