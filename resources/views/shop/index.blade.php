@extends('layouts.shop')

@section('content')
    <div class="mb-6">
        <h1 class="text-2xl font-semibold mb-3">Products</h1>

        <form class="flex flex-col md:flex-row gap-2 md:items-center">
            <input name="search" value="{{ request('search') }}"
                   placeholder="Search products..."
                   class="w-full md:w-72 border rounded-xl px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-blue-500"/>

            <select name="category"
                    class="border rounded-xl px-3 py-2 text-sm">
                <option value="">All Categories</option>
                @foreach($categories as $c)
                    <option value="{{ $c->id }}" @selected(request('category')==$c->id)>
                        {{ $c->name }}
                    </option>
                @endforeach
            </select>

            <button type="submit"
                    class="px-4 py-2 rounded-xl bg-blue-700 text-white text-sm">
                Filter
            </button>
        </form>
    </div>

    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-4">
        @foreach($products as $p)
            <div class="border rounded-2xl p-4 bg-white flex flex-col hover:shadow-sm transition">
                {{-- Info + link to details --}}
                <a href="{{ route('shop.show', $p) }}" class="block mb-3">
                    <div class="text-base font-semibold">{{ $p->name }}</div>
                    <div class="text-xs text-gray-500">
                        {{ $p->category->name ?? 'Uncategorized' }}
                    </div>
                    <div class="mt-1 text-blue-700 font-bold">
                        ₱{{ number_format($p->price, 2) }}
                    </div>
                    <div class="text-xs text-gray-500 mt-1">
                        Stock: {{ $p->stock }}
                    </div>
                </a>

                {{-- VERY CLEAR Add to Cart button --}}
                <form method="POST" action="{{ route('cart.add', $p) }}" class="mt-auto">
                    @csrf
                    <button type="submit"
                            class="w-full px-3 py-2 rounded-xl bg-blue-700 text-white text-sm font-semibold hover:bg-blue-800 transition">
                        Add to Cart
                    </button>
                </form>
            </div>
        @endforeach
    </div>

    <div class="mt-6">
        {{ $products->withQueryString()->links() }}
    </div>
@endsection
