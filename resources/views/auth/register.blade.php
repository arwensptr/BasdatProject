<x-guest-layout>
    <div class="relative min-h-screen overflow-hidden">

        {{-- Background --}}
        <img src="{{ asset('images/login-bg.jpg') }}" alt="Background"
             class="absolute inset-0 -z-10 h-full w-full object-cover">
        <div class="absolute inset-0 -z-10 bg-gradient-to-b from-black/30 via-black/10 to-white/10"></div>

        {{-- Brand di pojok kiri atas --}}
        <a href="{{ route('home') }}" class="absolute left-6 top-6 z-20 flex items-center gap-3 drop-shadow">
            <img src="{{ asset('images/logo.png') }}" alt="Logo Farmacheat" class="h-6 w-auto">
            <span class="text-xl font-bold text-white">Farmacheat</span>
        </a>


        {{-- Center container --}}
        <div class="relative z-10 flex min-h-screen items-center justify-center px-4 py-10">
            <div class="w-full max-w-[420px] rounded-3xl bg-white/90 backdrop-blur ring-1 ring-black/5 shadow-xl p-8">

                <h1 class="mb-1 text-2xl font-semibold text-brand-800">Daftar Akun Baru</h1>
                <p class="mb-6 text-sm text-gray-600">Silakan isi data untuk membuat akun.</p>

                <form method="POST" action="{{ route('register') }}" class="space-y-5">
                    @csrf

                    {{-- Name --}}
                    <div>
                        <label for="name" class="block text-sm font-medium text-gray-700">Nama Lengkap</label>
                        <input id="name" name="name" type="text" value="{{ old('name') }}" required autofocus autocomplete="name"
                               class="mt-1 block w-full rounded-xl border-gray-300 focus:border-brand-400 focus:ring-brand-300">
                        <x-input-error :messages="$errors->get('name')" class="mt-2" />
                    </div>

                    {{-- Email --}}
                    <div>
                        <label for="email" class="block text-sm font-medium text-gray-700">Email</label>
                        <input id="email" name="email" type="email" value="{{ old('email') }}" required autocomplete="username"
                               class="mt-1 block w-full rounded-xl border-gray-300 focus:border-brand-400 focus:ring-brand-300">
                        <x-input-error :messages="$errors->get('email')" class="mt-2" />
                    </div>

                    {{-- Password --}}
                    <div>
                        <label for="password" class="block text-sm font-medium text-gray-700">Password</label>
                        <input id="password" name="password" type="password" required autocomplete="new-password"
                               class="mt-1 block w-full rounded-xl border-gray-300 focus:border-brand-400 focus:ring-brand-300">
                        <x-input-error :messages="$errors->get('password')" class="mt-2" />
                    </div>

                    {{-- Confirm Password --}}
                    <div>
                        <label for="password_confirmation" class="block text-sm font-medium text-gray-700">Konfirmasi Password</label>
                        <input id="password_confirmation" name="password_confirmation" type="password" required autocomplete="new-password"
                               class="mt-1 block w-full rounded-xl border-gray-300 focus:border-brand-400 focus:ring-brand-300">
                        <x-input-error :messages="$errors->get('password_confirmation')" class="mt-2" />
                    </div>

                    {{-- Submit --}}
                    <button
                        class="w-full inline-flex items-center justify-center rounded-xl bg-brand-500 px-4 py-3
                               font-semibold text-white shadow-soft transition hover:bg-brand-600">
                        Daftar
                    </button>
                </form>

                {{-- Login link --}}
                <p class="mt-6 text-center text-sm text-gray-600">
                    Sudah punya akun?
                    <a href="{{ route('login') }}" class="font-medium text-brand-700 hover:underline">Masuk</a>
                </p>
            </div>
        </div>
    </div>
</x-guest-layout>