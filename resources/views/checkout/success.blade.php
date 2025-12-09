{{-- resources/views/checkout/success.blade.php --}}
<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            Payment Successful
        </h2>
    </x-slot>

    <div class="py-10">
        <div class="max-w-3xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white p-6 rounded-2xl shadow border">
                <h3 class="text-lg font-bold text-green-700 mb-2">
                    ✅ Thank you! Your order has been placed.
                </h3>

                <p class="text-sm text-gray-600">
                    Order Number:
                    <span class="font-semibold">{{ $order->order_number ?? $order->id }}</span>
                </p>

                <p class="text-sm text-gray-600 mt-1">
                    Status:
                    <span class="font-semibold">{{ $order->status }}</span>
                </p>

                <div class="mt-6 flex gap-3">
                    <a href="{{ route('shop.index') }}"
                       class="px-4 py-2 rounded-xl bg-blue-600 text-white text-sm hover:bg-blue-700">
                        Back to Shop
                    </a>

                    {{-- Go to the user's order history --}}
                    <a href="{{ url('/my-orders') }}"
                       class="px-4 py-2 rounded-xl border text-sm hover:border-blue-500 hover:text-blue-700">
                        View My Orders
                    </a>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
