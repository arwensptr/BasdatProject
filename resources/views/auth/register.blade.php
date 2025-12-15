<x-guest-layout>
    <div class="relative min-h-screen overflow-hidden">

        {{-- Background --}}
        <img src="{{ asset('images/login-bg.jpg') }}" alt="Background"
             class="absolute inset-0 -z-10 h-full w-full object-cover">
        <div class="absolute inset-0 -z-10 bg-gradient-to-b from-black/30 via-black/10 to-white/10"></div>

        {{-- Brand --}}
        <a href="{{ route('home') }}" class="absolute left-6 top-6 z-20 flex items-center gap-3 drop-shadow">
            <img src="{{ asset('images/logo.png') }}" alt="Logo Farmacheat" class="h-6 w-auto">
            <span class="text-xl font-bold text-white">Farmacheat</span>
        </a>

        {{-- Form Container --}}
        <div class="relative z-10 flex min-h-screen items-center justify-center px-4 py-10">
            <div class="w-full max-w-[480px] rounded-3xl bg-white/90 backdrop-blur ring-1 ring-black/5 shadow-xl p-8"> 
                {{-- Note: Lebar max-w saya naikkan sedikit jadi 480px biar lebih lega --}}

                <h1 class="mb-1 text-2xl font-semibold text-brand-800">Daftar Akun Baru</h1>
                <p class="mb-6 text-sm text-gray-600">Lengkapi biodata diri Anda.</p>

                <form method="POST" action="{{ route('register') }}" class="space-y-4">
                    @csrf

                    {{-- 1. Nama Lengkap --}}
                    <div>
                        <label for="name" class="block text-sm font-medium text-gray-700">Nama Lengkap</label>
                        <input id="name" name="name" type="text" value="{{ old('name') }}" required autofocus autocomplete="name"
                               class="mt-1 block w-full rounded-xl border-gray-300 focus:border-brand-400 focus:ring-brand-300">
                        <x-input-error :messages="$errors->get('name')" class="mt-2" />
                    </div>

                    {{-- Grid untuk Tanggal Lahir & Gender (Biar rapi sebelahan) --}}
                    <div class="grid grid-cols-2 gap-4">
                        {{-- 2. Tanggal Lahir --}}
                        <div>
                            <label for="birth_date" class="block text-sm font-medium text-gray-700">Tanggal Lahir</label>
                            <input id="birth_date" name="birth_date" type="date" value="{{ old('birth_date') }}" required
                                   class="mt-1 block w-full rounded-xl border-gray-300 focus:border-brand-400 focus:ring-brand-300">
                            <x-input-error :messages="$errors->get('birth_date')" class="mt-2" />
                        </div>

                        {{-- 3. Gender --}}
                        <div>
                            <label for="gender" class="block text-sm font-medium text-gray-700">Jenis Kelamin</label>
                            <select id="gender" name="gender" required
                                    class="mt-1 block w-full rounded-xl border-gray-300 focus:border-brand-400 focus:ring-brand-300">
                                <option value="" disabled {{ old('gender') ? '' : 'selected' }}>Pilih...</option>
                                <option value="L" {{ old('gender') == 'L' ? 'selected' : '' }}>Laki-laki</option>
                                <option value="P" {{ old('gender') == 'P' ? 'selected' : '' }}>Perempuan</option>
                            </select>
                            <x-input-error :messages="$errors->get('gender')" class="mt-2" />
                        </div>
                    </div>

                    {{-- 4. Alamat --}}
                    <div>
                        <label for="address" class="block text-sm font-medium text-gray-700">Alamat Domisili</label>
                        <textarea id="address" name="address" required rows="2"
                                  class="mt-1 block w-full rounded-xl border-gray-300 focus:border-brand-400 focus:ring-brand-300">{{ old('address') }}</textarea>
                        <x-input-error :messages="$errors->get('address')" class="mt-2" />
                    </div>

                    {{-- 5. Email --}}
                    <div>
                        <label for="email" class="block text-sm font-medium text-gray-700">Email</label>
                        <input id="email" name="email" type="email" value="{{ old('email') }}" required autocomplete="username"
                               class="mt-1 block w-full rounded-xl border-gray-300 focus:border-brand-400 focus:ring-brand-300">
                        <x-input-error :messages="$errors->get('email')" class="mt-2" />
                    </div>

                    {{-- 6. Password --}}
                    <div>
                        <label for="password" class="block text-sm font-medium text-gray-700">Password</label>
                        <input id="password" name="password" type="password" required autocomplete="new-password"
                               class="mt-1 block w-full rounded-xl border-gray-300 focus:border-brand-400 focus:ring-brand-300">
                        <x-input-error :messages="$errors->get('password')" class="mt-2" />
                    </div>

                    {{-- 7. Confirm Password --}}
                    <div>
                        <label for="password_confirmation" class="block text-sm font-medium text-gray-700">Konfirmasi Password</label>
                        <input id="password_confirmation" name="password_confirmation" type="password" required autocomplete="new-password"
                               class="mt-1 block w-full rounded-xl border-gray-300 focus:border-brand-400 focus:ring-brand-300">
                        <x-input-error :messages="$errors->get('password_confirmation')" class="mt-2" />
                    </div>

                    {{-- Submit --}}
                    <button class="w-full inline-flex items-center justify-center rounded-xl bg-brand-500 px-4 py-3 font-semibold text-white shadow-soft transition hover:bg-brand-600 mt-2">
                        Daftar Sekarang
                    </button>
                </form>

                <p class="mt-6 text-center text-sm text-gray-600">
                    Sudah punya akun?
                    <a href="{{ route('login') }}" class="font-medium text-brand-700 hover:underline">Masuk</a>
                </p>
            </div>
        </div>
    </div>
</x-guest-layout>