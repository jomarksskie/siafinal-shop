@extends('layouts.admin')

@section('content')
<h1 class="text-xl font-semibold mb-4">Edit Category</h1>

<form method="POST" action="{{ route('admin.categories.update', $category) }}" class="max-w-md space-y-4">
    @csrf
    @method('PUT')

    <div>
        <label class="block text-sm mb-1">Name</label>
        <input type="text" name="name"
               value="{{ old('name', $category->name) }}"
               class="w-full border rounded-xl px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-brand-500">
    </div>

    <div class="flex gap-2">
        <button class="px-4 py-2 rounded-xl bg-brand-700 text-white text-sm">
            Update
        </button>
        <a href="{{ route('admin.categories.index') }}" class="px-4 py-2 text-sm border rounded-xl">
            Cancel
        </a>
    </div>
</form>
@endsection
