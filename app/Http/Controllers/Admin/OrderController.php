<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Order;
use Illuminate\Http\Request;

class OrderController extends Controller
{
    public function index(Request $request)
    {
        // eager load the relations properly
        $q = Order::with(['items.product', 'user'])->latest();

        if ($status = $request->get('status')) {
            $q->where('status', $status);
        }

        $orders = $q->paginate(10);

        return view('admin.orders.index', compact('orders'));
    }

    public function update(Request $request, Order $order)
    {
        $data = $request->validate([
            'status' => 'required|in:Pending,Processing,Completed,Cancelled',
        ]);

        $order->update([
            'status' => $data['status'],
        ]);

        return back()->with('success', 'Order status updated.');
    }
}
