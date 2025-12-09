@extends('layouts.admin')

@section('content')
<div class="flex items-center justify-between mb-6">
    <h1 class="text-xl font-semibold">Categories</h1>
    <a href="{{ route('admin.categories.create') }}"
       class="px-4 py-2 rounded-xl bg-brand-700 text-white text-sm">
        + New Category
    </a>
</div>

<table class="w-full text-sm bg-white border rounded-2xl overflow-hidden">
    <thead class="bg-slate-100 text-left">
        <tr>
            <th class="px-4 py-2">ID</th>
            <th class="px-4 py-2">Name</th>
            <th class="px-4 py-2 w-40">Actions</th>
        </tr>
    </thead>
    <tbody>
    @forelse($categories as $category)
        <tr class="border-t">
            <td class="px-4 py-2">{{ $category->id }}</td>
            <td class="px-4 py-2">{{ $category->name }}</td>
            <td class="px-4 py-2">
                <div class="flex gap-2">
                    <a href="{{ route('admin.categories.edit', $category) }}"
                       class="text-xs px-3 py-1 rounded-lg border border-slate-300 hover:border-brand-500">
                        Edit
                    </a>
                    <form method="POST"
                          action="{{ route('admin.categories.destroy', $category) }}"
                          onsubmit="return confirm('Delete this category?')">
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
            <td colspan="3" class="px-4 py-4 text-center text-slate-500">
                No categories yet.
            </td>
        </tr>
    @endforelse
    </tbody>
</table>

<div class="mt-4">
    {{ $categories->links() }}
</div>
@endsection
