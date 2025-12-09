@extends('layouts.admin')

@section('content')
<div class="flex items-center justify-between mb-6">
    <h1 class="text-xl font-semibold">Products</h1>
    <a href="{{ route('admin.products.create') }}"
       class="px-4 py-2 rounded-xl bg-brand-700 text-white text-sm">
        + New Product
    </a>
</div>

<table class="w-full text-sm bg-white border rounded-2xl overflow-hidden">
    <thead class="bg-slate-100 text-left">
        <tr>
            <th class="px-4 py-2">ID</th>
            <th class="px-4 py-2">Name</th>
            <th class="px-4 py-2">Category</th>
            <th class="px-4 py-2">Price</th>
            <th class="px-4 py-2">Stock</th>
            <th class="px-4 py-2">Active</th>
            <th class="px-4 py-2 w-48">Actions</th>
        </tr>
    </thead>
    <tbody>
    @forelse($products as $product)
        <tr class="border-t">
            <td class="px-4 py-2">{{ $product->id }}</td>
            <td class="px-4 py-2">{{ $product->name }}</td>
            <td class="px-4 py-2">{{ $product->category?->name }}</td>
            <td class="px-4 py-2">₱{{ number_format($product->price,2) }}</td>
            <td class="px-4 py-2">{{ $product->stock }}</td>
            <td class="px-4 py-2">{{ $product->is_active ? 'Yes' : 'No' }}</td>
            <td class="px-4 py-2">
                <div class="flex flex-wrap gap-2">
                    <a href="{{ route('admin.products.edit', $product) }}"
                       class="text-xs px-3 py-1 rounded-lg border border-slate-300 hover:border-brand-500">
                        Edit
                    </a>
                    <form method="POST"
                          action="{{ route('admin.products.destroy', $product) }}"
                          onsubmit="return confirm('Delete this product?')">
                        @csrf
                        @method('DELETE')
                        <button class="text-xs px-3 py-1 rounded-lg border border-red-400 text-red-600">
                            Delete
                        </button>
                    </form>
                </div>
            </td>
        </tr>
    @empty
        <tr>
            <td colspan="7" class="px-4 py-4 text-center text-slate-500">
                No products yet.
            </td>
        </tr>
    @endforelse
    </tbody>
</table>

<div class="mt-4">
    {{ $products->links() }}
</div>
@endsection
