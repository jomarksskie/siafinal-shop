<?php

namespace App\Http\Controllers;

use App\Models\Order;
use Illuminate\Http\Request;

class OrderHistoryController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index()
    {
        $orders = Order::where('user_id', auth()->id())
            ->latest()
            ->with('items.product')   // if you have relation
            ->get();

        return view('orders.my', compact('orders'));
    }
}
