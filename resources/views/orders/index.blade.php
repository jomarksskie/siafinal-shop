@extends('layouts.shop')

@section('content')
<div class="max-w-4xl mx-auto bg-white border rounded-2xl p-5">
    <h2 class="text-lg font-semibold mb-4">My Orders</h2>

    @forelse($orders as $o)
        <div class="border rounded-xl p-4 mb-3">
            <div class="flex justify-between text-sm">
                <div>
                    <div class="font-semibold">{{ $o->order_number }}</div>
                    <div class="text-slate-500">{{ $o->created_at->format('M d, Y h:i A') }}</div>
                </div>
                <div class="text-right">
                    <div class="font-bold">₱{{ number_format($o->total,2) }}</div>
                    <div class="text-xs px-2 py-1 rounded bg-blue-50 inline-block">
                        {{ $o->status }}
                    </div>
                </div>
            </div>
        </div>
    @empty
        <div class="text-sm text-slate-500">No orders yet.</div>
    @endforelse
</div>
@endsection
