{{-- resources/views/cart/index.blade.php --}}
<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            Cart
        </h2>
    </x-slot>

    <div class="py-8">
        <div class="max-w-5xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white shadow-sm rounded-2xl border overflow-hidden">

                <table class="min-w-full text-sm">
                    <thead class="bg-blue-50">
                        <tr>
                            <th class="px-4 py-3 text-left font-semibold">Product</th>
                            <th class="px-4 py-3 text-left font-semibold">Price</th>
                            <th class="px-4 py-3 text-left font-semibold">Qty</th>
                            <th class="px-4 py-3 text-left font-semibold">Total</th>
                        </tr>
                    </thead>
                    <tbody>
                        @php $computedSubtotal = 0; @endphp

                        @forelse($items as $item)
                            @php
                                $name = data_get($item, 'product.name') 
                                        ?? data_get($item,'name') 
                                        ?? 'Product';

                                $price = (float) data_get($item, 'price', 0);
                                $qty   = (int) data_get($item, 'quantity', 1);

                                $lineTotal = $price * $qty;
                                $computedSubtotal += $lineTotal;
                            @endphp

                            <tr class="border-t">
                                <td class="px-4 py-2">
                                    {{ $name }}
                                </td>
                                <td class="px-4 py-2">
                                    ₱{{ number_format($price, 2) }}
                                </td>
                                <td class="px-4 py-2">
                                    {{ $qty }}
                                </td>
                                <td class="px-4 py-2 font-semibold">
                                    ₱{{ number_format($lineTotal, 2) }}
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="4" class="px-4 py-6 text-center text-gray-500">
                                    Your cart is empty.
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            {{-- Subtotal --}}
            <div class="mt-4 flex justify-between items-center">
                <div class="text-sm text-gray-500">
                    Subtotal:
                </div>
                <div class="text-lg font-semibold">
                    ₱{{ number_format($subtotal ?? $computedSubtotal, 2) }}
                </div>
            </div>

            <div class="mt-6 flex justify-end gap-3">
                <a href="{{ route('shop.index') }}"
                   class="px-4 py-2 border rounded-xl text-sm hover:border-blue-500 hover:text-blue-700">
                    Continue Shopping
                </a>

                <a href="{{ route('checkout.form') }}"
                   class="px-4 py-2 rounded-xl bg-blue-600 text-white text-sm hover:bg-blue-700">
                    Checkout
                </a>
            </div>
        </div>
    </div>
</x-app-layout>
