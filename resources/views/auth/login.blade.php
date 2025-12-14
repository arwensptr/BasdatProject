<x-guest-layout>
    <div class="relative min-h-screen overflow-hidden">

        {{-- Background --}}
        <img src="{{ asset('images/login-bg.jpg') }}" alt="Login Background"
             class="absolute inset-0 -z-10 h-full w-full object-cover">
        <div class="absolute inset-0 -z-10 bg-gradient-to-b from-black/30 via-black/10 to-white/10"></div>

        {{-- Brand di pojok kiri atas --}}
        <a href="{{ route('home') }}" class="absolute left-6 top-6 z-20 flex items-center gap-3 drop-shadow">
            <img src="{{ asset('images/logo.png') }}" alt="Logo Farmacheat" class="h-6">
            <span class="text-xl font-bold text-white">Farmacheat</span>
        </a>

        {{-- Center container --}}
        <div class="relative z-10 flex min-h-screen items-center justify-center px-4 py-10">
            <div class="w-full max-w-[420px] rounded-3xl bg-white/90 backdrop-blur ring-1 ring-black/5 shadow-xl p-8">

                <h1 class="mb-1 text-2xl font-semibold text-brand-800">Masuk</h1>
                <p class="mb-6 text-sm text-gray-600">Silakan login untuk melanjutkan.</p>

                <x-auth-session-status class="mb-4" :status="session('status')" />

                <form method="POST" action="{{ route('login') }}" class="space-y-5">
                    @csrf

                    {{-- Email --}}
                    <div>
                        <label for="email" class="block text-sm font-medium text-gray-700">Email</label>
                        <input id="email" name="email" type="email" autocomplete="username" autofocus required
                               value="{{ old('email') }}"
                               class="mt-1 block w-full rounded-xl border-gray-300 focus:border-brand-400 focus:ring-brand-300">
                        <x-input-error :messages="$errors->get('email')" class="mt-2" />
                    </div>

                    {{-- Password --}}
                    <div>
                        <label for="password" class="block text-sm font-medium text-gray-700">Password</label>
                        {{-- [FIX] Tambahkan div pembungkus dengan class="relative" di sini --}}
                        <div class="relative mt-1">
                            <input id="password" name="password" type="password" autocomplete="current-password" required
                                   class="block w-full rounded-xl border-gray-300 focus:border-brand-400 focus:ring-brand-300">
                            
                            <span class="absolute inset-y-0 right-0 flex items-center pr-3 cursor-pointer" id="togglePassword">
                                <ion-icon name="eye-outline" class="text-xl text-gray-600 hover:text-cyan-600"></ion-icon>
                            </span>
                        </div>
                        <x-input-error :messages="$errors->get('password')" class="mt-2" />
                    </div>

                    {{-- Remember + Forgot --}}
                    <div class="flex items-center justify-between">
                        <label class="inline-flex items-center gap-2">
                            <input name="remember" type="checkbox"
                                   class="rounded border-gray-300 text-brand-600 focus:ring-brand-400">
                            <span class="text-sm text-gray-600 select-none">Ingat saya</span>
                        </label>
                        @if (Route::has('forgot-password'))
                            <a href="{{ route('forgot-password') }}" class="text-sm text-brand-700 hover:underline">
                                Lupa password?
                            </a>
                        @endif
                    </div>

                    {{-- Submit --}}
                    <button
                        class="w-full inline-flex items-center justify-center rounded-xl bg-brand-500 px-4 py-3
                               font-semibold text-white shadow-soft transition hover:bg-brand-600">
                        Masuk
                    </button>
                </form>

                {{-- Register link (opsional) --}}
                @if (Route::has('register'))
                    <p class="mt-6 text-center text-sm text-gray-600">
                        Belum punya akun?
                        <a href="{{ route('register') }}" class="font-medium text-brand-700 hover:underline">Daftar</a>
                    </p>
                @endif
            </div>
        </div>
    </div>
    <script type="module" src="https://unpkg.com/ionicons@5.5.2/dist/ionicons/ionicons.esm.js"></script>
    <script nomodule src="https://unpkg.com/ionicons@5.5.2/dist/ionicons/ionicons.js"></script>
    <script>
        const togglePassword = document.querySelector('#togglePassword');
        const passwordInput = document.querySelector('#password');

        togglePassword.addEventListener('click', function () {
            // Ganti tipe input dari 'password' ke 'text' atau sebaliknya
            const type = passwordInput.getAttribute('type') === 'password' ? 'text' : 'password';
            passwordInput.setAttribute('type', type);
            
            // Ganti ikon mata
            const icon = this.querySelector('ion-icon');
            icon.setAttribute('name', type === 'password' ? 'eye-outline' : 'eye-off-outline');
        });
    </script>
</x-guest-layout>
