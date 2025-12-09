<h2>Thanks for your order!</h2>
<p>Order #: {{ $order->order_number }}</p>
<p>Status: {{ $order->status }}</p>
<p>Total: ₱{{ number_format($order->total, 2) }}</p>
