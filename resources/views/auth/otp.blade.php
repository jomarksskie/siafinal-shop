<x-guest-layout>
    <div class="max-w-md mx-auto mt-10 p-6 bg-white rounded-xl shadow">
        <h2 class="text-lg font-bold mb-2">OTP Verification</h2>
        <p class="text-sm text-gray-600 mb-4">
            We sent a 6-digit OTP to your email.
        </p>

        @if(session('success'))
            <div class="text-green-700 text-sm mb-3">
                {{ session('success') }}
            </div>
        @endif

        <form method="POST" action="{{ route('otp.verify') }}">
            @csrf
            <input name="otp" placeholder="Enter OTP"
                   class="w-full border rounded-lg px-3 py-2 mb-2"/>

            @error('otp')
                <p class="text-red-600 text-sm mb-2">{{ $message }}</p>
            @enderror

            <button class="w-full bg-blue-600 text-white py-2 rounded-lg">
                Verify OTP
            </button>
        </form>

        <form method="POST" action="{{ route('otp.resend') }}" class="mt-3">
            @csrf
            <button class="text-sm text-blue-600 underline">
                Resend OTP
            </button>
        </form>
    </div>
</x-guest-layout>
