<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            Dashboard
        </h2>
    </x-slot>

    <div class="py-8">
        <div class="max-w-6xl mx-auto sm:px-6 lg:px-8 space-y-6">

            {{-- CUSTOMER LINKS (everyone sees this) --}}
            <div class="bg-white p-6 rounded-2xl shadow-sm border">
                <h3 class="text-lg font-semibold mb-3 text-blue-700">Customer Panel</h3>

                <div class="flex flex-wrap gap-3 text-sm">
                    <a href="{{ route('shop.index') }}"
                       class="px-4 py-2 rounded-xl border hover:border-blue-500 hover:text-blue-700 transition">
                        Shop
                    </a>

                    <a href="{{ route('cart.index') }}"
                       class="px-4 py-2 rounded-xl border hover:border-blue-500 hover:text-blue-700 transition">
                        Cart
                    </a>

                    <a href="{{ route('checkout.form') }}"
                       class="px-4 py-2 rounded-xl border hover:border-blue-500 hover:text-blue-700 transition">
                        Checkout
                    </a>

                    {{-- 🔹 My Orders link --}}
                    <a href="{{ route('orders.mine') }}"
                       class="px-4 py-2 rounded-xl border hover:border-blue-500 hover:text-blue-700 transition">
                        My Orders
                    </a>

                    <a href="{{ route('profile.edit') }}"
                       class="px-4 py-2 rounded-xl border hover:border-blue-500 hover:text-blue-700 transition">
                        Profile
                    </a>
                </div>
            </div>

            {{-- ADMIN LINKS (only admins see this) --}}
            @role('admin')
            <div class="bg-white p-6 rounded-2xl shadow-sm border">
                <h3 class="text-lg font-semibold mb-3 text-blue-700">Admin Panel</h3>

                <div class="flex flex-wrap gap-3 text-sm">
                    <a href="{{ route('admin.products.index') }}"
                       class="px-4 py-2 rounded-xl border hover:border-blue-500 hover:text-blue-700 transition">
                        Products
                    </a>

                    <a href="{{ route('admin.categories.index') }}"
                       class="px-4 py-2 rounded-xl border hover:border-blue-500 hover:text-blue-700 transition">
                        Categories
                    </a>

                    <a href="{{ route('admin.orders.index') }}"
                       class="px-4 py-2 rounded-xl border hover:border-blue-500 hover:text-blue-700 transition">
                        Orders
                    </a>
                </div>
            </div>
            @endrole

            {{-- small message --}}
            <div class="bg-blue-50 p-4 rounded-xl text-sm text-blue-700 border border-blue-100">
                You’re logged in!
            </div>
        </div>
    </div>
</x-app-layout>
