<?php

namespace App\Http\Controllers;

use App\Mail\OrderPlacedMail;
use Illuminate\Support\Facades\Mail;
use App\Services\ShippingService;
use App\Services\CartService;
use App\Services\PayPalService; // <-- we’ll create this
use App\Models\Order;
use App\Models\OrderItem;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class CheckoutController extends Controller
{
    public function form(CartService $cart, ShippingService $shipping)
    {
        $items = $cart->get();              // collection of cart items (arrays)
        $subtotal = $cart->subtotal();

        $shippingFee = $shipping->getRate(auth()->user()->city ?? 'Manila');
        $total = $subtotal + $shippingFee;

        return view('checkout.form', [
            'cart' => $items,
            'subtotal' => $subtotal,
            'shippingFee' => $shippingFee,
            'total' => $total,
        ]);
    }

    public function pay(
        Request $request,
        CartService $cart,
        ShippingService $shipping,
        PayPalService $paypal
    ) {
        abort_if($cart->get()->isEmpty(), 403);

        $data = $request->validate([
            'full_name' => 'required|string|max:120',
            'phone' => 'required|string|max:30',
            'address' => 'required|string|max:255',
            'city' => 'required|string|max:120',
            'notes' => 'nullable|string|max:500',
        ]);

        $subtotal = $cart->subtotal();
        $shippingFee = $shipping->getRate($data['city'] ?? 'Manila');
        $total = $subtotal + $shippingFee;

        // 1) create order in Pending state
        $order = Order::create([
            'user_id' => $request->user()->id,
            'order_number' => 'ORD-' . Str::upper(Str::random(8)),
            'status' => 'Pending',
            'subtotal' => $subtotal,
            'shipping_fee' => $shippingFee,
            'total' => $total,
            'delivery_details' => $data,
            'payment_provider' => 'paypal',
        ]);

        // 2) save items
        foreach ($cart->get() as $item) {
            OrderItem::create([
                'order_id' => $order->id,
                'product_id' => $item['product_id'],
                'product_name' => $item['name'],
                'unit_price' => $item['price'],
                'quantity' => $item['quantity'],
                'line_total' => $item['price'] * $item['quantity'],
            ]);
        }

        // 3) create PayPal order + redirect to approval
        $paypalOrder = $paypal->createOrder($order);

        $order->update(['payment_ref' => $paypalOrder['id']]);

        return redirect($paypalOrder['approve_url']);
    }

    public function success(Order $order, CartService $cart, PayPalService $paypal)
    {
        // capture PayPal payment
        $paypal->captureOrder($order->payment_ref);

        $order->update(['status' => 'Processing']);

        // send mail after paid
        if ($order->user) {
            Mail::to($order->user->email)->send(new OrderPlacedMail($order));
        }

        $cart->clear();

        return view('checkout.success', compact('order'));
    }

    public function cancel(Order $order)
    {
        $order->update(['status' => 'Cancelled']);
        return view('checkout.cancel', compact('order'));
    }
}
