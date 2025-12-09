@extends('layouts.admin')

@section('content')
<h1 class="text-xl font-semibold mb-4">New Product</h1>

<form method="POST" action="{{ route('admin.products.store') }}"
      enctype="multipart/form-data"
      class="space-y-4 max-w-xl">
    @csrf

    <div>
        <label class="block text-sm mb-1">Name</label>
        <input type="text" name="name" value="{{ old('name') }}"
               class="w-full border rounded-xl px-3 py-2 text-sm focus:ring-2 focus:ring-brand-500">
    </div>

    <div>
        <label class="block text-sm mb-1">Category</label>
        <select name="category_id"
                class="w-full border rounded-xl px-3 py-2 text-sm">
            <option value="">-- select --</option>
            @foreach($categories as $c)
                <option value="{{ $c->id }}" @selected(old('category_id')==$c->id)>
                    {{ $c->name }}
                </option>
            @endforeach
        </select>
    </div>

    <div>
        <label class="block text-sm mb-1">Description</label>
        <textarea name="description" rows="4"
                  class="w-full border rounded-xl px-3 py-2 text-sm">{{ old('description') }}</textarea>
    </div>

    <div class="grid grid-cols-2 gap-4">
        <div>
            <label class="block text-sm mb-1">Price</label>
            <input type="number" step="0.01" min="0" name="price" value="{{ old('price') }}"
                   class="w-full border rounded-xl px-3 py-2 text-sm">
        </div>
        <div>
            <label class="block text-sm mb-1">Stock</label>
            <input type="number" min="0" name="stock" value="{{ old('stock') }}"
                   class="w-full border rounded-xl px-3 py-2 text-sm">
        </div>
    </div>

    <div>
        <label class="block text-sm mb-1">Image</label>
        <input type="file" name="image"
               class="w-full text-sm">
    </div>

    <div class="flex items-center gap-2">
        <input type="checkbox" name="is_active" value="1"
               @checked(old('is_active', true))
               class="rounded border-slate-300">
        <span class="text-sm">Active</span>
    </div>

    <div class="flex gap-2">
        <button class="px-4 py-2 rounded-xl bg-brand-700 text-white text-sm">
            Save
        </button>
        <a href="{{ route('admin.products.index') }}" class="px-4 py-2 text-sm border rounded-xl">
            Cancel
        </a>
    </div>
</form>
@endsection
