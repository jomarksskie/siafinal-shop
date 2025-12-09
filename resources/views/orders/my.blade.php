<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            My Orders
        </h2>
    </x-slot>

    <div class="py-8">
        <div class="max-w-5xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm rounded-2xl border">
                <table class="min-w-full text-sm">
                    <thead class="bg-blue-50">
                        <tr>
                            <th class="px-4 py-3 text-left font-semibold">#</th>
                            <th class="px-4 py-3 text-left font-semibold">Total</th>
                            <th class="px-4 py-3 text-left font-semibold">Status</th>
                            <th class="px-4 py-3 text-left font-semibold">Payment</th>
                            <th class="px-4 py-3 text-left font-semibold">Created</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($orders as $order)
                            <tr class="border-t">
                                <td class="px-4 py-2">{{ $order->id }}</td>
                                <td class="px-4 py-2">₱{{ number_format($order->total, 2) }}</td>
                                <td class="px-4 py-2">{{ ucfirst($order->status) }}</td>
                                <td class="px-4 py-2">{{ $order->payment_method }}</td>
                                <td class="px-4 py-2">{{ $order->created_at->format('Y-m-d H:i') }}</td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="5" class="px-4 py-6 text-center text-gray-500">
                                    You have no orders yet.
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</x-app-layout>
