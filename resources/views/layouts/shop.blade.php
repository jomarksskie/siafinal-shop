<!doctype html>
<html lang="en">
<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width,initial-scale=1" />
    @vite(['resources/css/app.css','resources/js/app.js'])
    <title>{{ config('app.name') }}</title>
</head>
<body class="bg-white text-slate-900">
    <nav class="border-b bg-white sticky top-0 z-10">
        <div class="max-w-6xl mx-auto px-4 py-3 flex items-center justify-between">
            <a href="{{ route('shop.index') }}" class="text-xl font-semibold text-brand-700">
                SiaFInalShop
            </a>

            <div class="flex items-center gap-4">
                <a href="{{ route('cart.index') }}" class="text-sm font-medium hover:text-brand-700">
                    Cart
                </a>

                @auth
                    <span class="text-sm text-slate-600">{{ auth()->user()->name }}</span>
                    <form method="POST" action="{{ route('logout') }}">
                        @csrf
                        <button class="text-sm text-brand-700 hover:underline">Logout</button>
                    </form>
                @else
                    <a href="{{ route('login') }}" class="text-sm text-brand-700 hover:underline">Login</a>
                @endauth
            </div>
        </div>
    </nav>

    <main class="max-w-6xl mx-auto px-4 py-8">
        @if(session('success'))
            <div class="mb-4 p-3 border border-brand-500 bg-brand-50 text-brand-700 rounded-xl">
                {{ session('success') }}
            </div>
        @endif
        @yield('content')
    </main>

    <footer class="border-t py-6 text-center text-sm text-slate-500">
        © {{ date('Y') }} SiaFInalShop
    </footer>
</body>
</html>
