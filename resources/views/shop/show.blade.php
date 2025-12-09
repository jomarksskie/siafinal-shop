@extends('layouts.shop')

@section('content')
    <div class="max-w-xl">
        <h1 class="text-2xl font-semibold mb-1">{{ $product->name }}</h1>

        <div class="text-sm text-gray-500 mb-4">
            {{ $product->category->name ?? 'Uncategorized' }}
        </div>

        <p class="mb-4 text-sm">
            {{ $product->description }}
        </p>

        <div class="mb-2 text-xl font-bold text-blue-700">
            ₱{{ number_format($product->price, 2) }}
        </div>

        <div class="mb-4 text-sm text-gray-600">
            Stock: {{ $product->stock }}
        </div>

        {{-- Add to Cart on detail page --}}
        <form method="POST" action="{{ route('cart.add', $product) }}" class="mt-2">
            @csrf
            <button type="submit"
                    class="px-4 py-2 rounded-xl bg-blue-700 text-white text-sm font-semibold hover:bg-blue-800 transition">
                Add to Cart
            </button>
        </form>

        <div class="mt-4">
            <a href="{{ route('shop.index') }}" class="text-sm text-blue-700 underline">
                ← Back to shop
            </a>
        </div>
    </div>
@endsection
