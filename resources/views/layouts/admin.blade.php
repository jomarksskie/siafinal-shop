<!doctype html>
<html lang="en">
<head>
    <meta charset="utf-8" />
    <title>Admin · {{ config('app.name') }}</title>
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="bg-slate-50 text-slate-900">

<nav class="bg-white border-b">
    <div class="max-w-6xl mx-auto px-4 py-3 flex items-center justify-between">
        <div class="flex items-center gap-3">
            <a href="{{ url('/') }}" class="text-lg font-semibold text-brand-700">
                {{ config('app.name', 'SIA Shop') }}
            </a>
            <span class="text-xs px-2 py-1 rounded-full bg-brand-50 text-brand-700 border border-brand-100">
                Admin
            </span>
        </div>
        <div class="flex items-center gap-4 text-sm">
            <a href="{{ route('admin.products.index') }}" class="hover:text-brand-700">Products</a>
            <a href="{{ route('admin.categories.index') }}" class="hover:text-brand-700">Categories</a>
            <a href="{{ route('admin.orders.index') }}" class="hover:text-brand-700">Orders</a>
            <a href="{{ route('dashboard') }}" class="hover:text-brand-700">Dashboard</a>

            <form method="POST" action="{{ route('logout') }}">
                @csrf
                <button class="text-sm text-brand-700 hover:underline">Logout</button>
            </form>
        </div>
    </div>
</nav>

<main class="max-w-6xl mx-auto px-4 py-8">
    @if(session('success'))
        <div class="mb-4 p-3 border border-brand-500 bg-brand-50 text-brand-700 rounded-xl text-sm">
            {{ session('success') }}
        </div>
    @endif

    @if($errors->any())
        <div class="mb-4 p-3 border border-red-400 bg-red-50 text-red-700 rounded-xl text-sm">
            <ul class="list-disc pl-5 space-y-1">
                @foreach($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    @yield('content')
</main>

</body>
</html>
