{{-- resources/views/checkout/cancel.blade.php --}}
<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            Payment Cancelled
        </h2>
    </x-slot>

    <div class="py-10">
        <div class="max-w-3xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white p-6 rounded-2xl shadow border">
                <h3 class="text-lg font-bold text-red-600 mb-2">
                    ❌ Payment cancelled.
                </h3>

                <p class="text-sm text-gray-600">
                    No worries — your cart is still saved. You can try again anytime.
                </p>

                <div class="mt-6 flex gap-3">
                    <a href="{{ route('cart.index') }}"
                       class="px-4 py-2 rounded-xl bg-blue-600 text-white text-sm hover:bg-blue-700">
                        Back to Cart
                    </a>

                    <a href="{{ route('shop.index') }}"
                       class="px-4 py-2 rounded-xl border text-sm hover:border-blue-500 hover:text-blue-700">
                        Continue Shopping
                    </a>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
