{{-- resources/views/checkout/form.blade.php --}}
@extends('layouts.shop')

@section('content')
<div class="max-w-4xl mx-auto grid md:grid-cols-2 gap-6">

    {{-- LEFT: shipping form --}}
    <div class="bg-white border rounded-2xl p-5">
        <h2 class="text-lg font-semibold mb-4">Delivery Details</h2>

        <form method="POST" action="{{ route('checkout.pay') }}" class="space-y-3">
            @csrf

            <div>
                <label class="text-sm font-medium">Full Name</label>
                <input name="full_name" required
                       class="w-full border rounded-xl px-3 py-2 text-sm"
                       value="{{ old('full_name', auth()->user()->name) }}">
            </div>

            <div>
                <label class="text-sm font-medium">Phone</label>
                <input name="phone" required
                       class="w-full border rounded-xl px-3 py-2 text-sm"
                       value="{{ old('phone') }}">
            </div>

            <div>
                <label class="text-sm font-medium">Address</label>
                <input name="address" required
                       class="w-full border rounded-xl px-3 py-2 text-sm"
                       value="{{ old('address') }}">
            </div>

            <div>
                <label class="text-sm font-medium">City</label>
                <input name="city" required
                       class="w-full border rounded-xl px-3 py-2 text-sm"
                       value="{{ old('city', auth()->user()->city) }}">
            </div>

            <div>
                <label class="text-sm font-medium">Notes (optional)</label>
                <textarea name="notes"
                          class="w-full border rounded-xl px-3 py-2 text-sm"
                          rows="3">{{ old('notes') }}</textarea>
            </div>

            <button class="w-full mt-2 px-4 py-2 rounded-xl bg-blue-600 text-white text-sm hover:bg-blue-700">
                Pay with PayPal
            </button>
        </form>
    </div>

    {{-- RIGHT: order summary --}}
    <div class="bg-white border rounded-2xl p-5">
        <h2 class="text-lg font-semibold mb-4">Order Summary</h2>

        <div class="space-y-2 text-sm">
            @foreach($cart as $item)
                <div class="flex justify-between">
                    <div>
                        <div class="font-medium">{{ $item['name'] }}</div>
                        <div class="text-slate-500">Qty: {{ $item['quantity'] }}</div>
                    </div>
                    <div class="font-semibold">
                        ₱{{ number_format($item['price'] * $item['quantity'], 2) }}
                    </div>
                </div>
            @endforeach
        </div>

        <hr class="my-4">

        <div class="text-sm space-y-1">
            <div class="flex justify-between">
                <span>Subtotal</span>
                <span>₱{{ number_format($subtotal,2) }}</span>
            </div>
            <div class="flex justify-between">
                <span>Shipping Fee</span>
                <span>₱{{ number_format($shippingFee,2) }}</span>
            </div>
            <div class="flex justify-between font-bold text-base mt-2">
                <span>Total</span>
                <span>₱{{ number_format($total,2) }}</span>
            </div>
        </div>
    </div>

</div>
@endsection
