@extends('layouts.admin')

@section('content')
<div class="flex items-center justify-between mb-6">
    <h1 class="text-xl font-semibold">Orders</h1>

    <form method="GET" class="flex items-center gap-2 text-sm">
        <select name="status" class="border rounded-xl px-3 py-2">
            <option value="">All statuses</option>
            @foreach(['Pending','Processing','Completed','Cancelled'] as $status)
                <option value="{{ $status }}" @selected(request('status') === $status)>
                    {{ $status }}
                </option>
            @endforeach
        </select>
        <button class="px-3 py-2 rounded-xl bg-brand-700 text-white text-xs">
            Filter
        </button>
    </form>
</div>

<table class="w-full text-sm bg-white border rounded-2xl overflow-hidden">
    <thead class="bg-slate-100 text-left">
        <tr>
            <th class="px-4 py-2">#</th>
            <th class="px-4 py-2">Customer</th>
            <th class="px-4 py-2">Total</th>
            <th class="px-4 py-2">Status</th>
            <th class="px-4 py-2">Payment</th>
            <th class="px-4 py-2">Created</th>
            <th class="px-4 py-2 w-56">Update</th>
        </tr>
    </thead>
    <tbody>
    @forelse($orders as $order)
        <tr class="border-t align-top">
            <td class="px-4 py-2">
                <div class="font-mono text-xs">{{ $order->order_number }}</div>
            </td>
            <td class="px-4 py-2">
                <div class="font-semibold text-xs">
                    {{ $order->user?->name ?? 'Guest' }}
                </div>
                <div class="text-xs text-slate-500">
                    {{ $order->delivery_details['full_name'] ?? '' }}
                </div>
            </td>
            <td class="px-4 py-2">
                ₱{{ number_format($order->total, 2) }}
            </td>
            <td class="px-4 py-2">
                <span class="px-2 py-1 text-xs rounded-full border
                    @if($order->status === 'Completed') border-emerald-400 text-emerald-700 bg-emerald-50
                    @elseif($order->status === 'Cancelled') border-red-400 text-red-700 bg-red-50
                    @elseif($order->status === 'Processing') border-sky-400 text-sky-700 bg-sky-50
                    @else border-slate-300 text-slate-700 bg-slate-50
                    @endif">
                    {{ $order->status }}
                </span>
            </td>
            <td class="px-4 py-2 text-xs">
                {{ strtoupper($order->payment_provider ?? '-') }}<br>
                <span class="text-slate-500">{{ $order->payment_ref }}</span>
            </td>
            <td class="px-4 py-2 text-xs">
                {{ $order->created_at->format('Y-m-d H:i') }}
            </td>
            <td class="px-4 py-2">
                <form method="POST" action="{{ route('admin.orders.update', $order) }}"
                      class="flex flex-col gap-2 text-xs">
                    @csrf
                    @method('PATCH')

                    <select name="status" class="border rounded-xl px-2 py-1 text-xs">
                        @foreach(['Pending','Processing','Completed','Cancelled'] as $status)
                            <option value="{{ $status }}" @selected($order->status === $status)>
                                {{ $status }}
                            </option>
                        @endforeach
                    </select>

                    <button type="submit"
                        class="px-3 py-1 rounded-lg bg-black text-white text-sm hover:bg-gray-800">
                    Save
                </button>

                </form>
            </td>
        </tr>
    @empty
        <tr>
            <td colspan="7" class="px-4 py-4 text-center text-slate-500">
                No orders yet.
            </td>
        </tr>
    @endforelse
    </tbody>
</table>

<div class="mt-4">
    {{ $orders->links() }}
</div>
@endsection
