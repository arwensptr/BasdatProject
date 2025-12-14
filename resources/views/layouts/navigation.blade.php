{{-- resources/views/layouts/navigation.blade.php --}}
<nav x-data="{ open: false }" class="relative z-50 bg-white/80 backdrop-blur border-b">
    <div class="mx-auto max-w-7xl px-4">
        <div class="flex h-16 items-center gap-3">
            {{-- Hamburger (mobile) --}}
            <button @click="open = !open"
                    class="md:hidden inline-flex items-center justify-center p-2 rounded hover:bg-brand-50"
                    aria-label="Toggle menu">
                <svg class="h-6 w-6 text-gray-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path x-show="!open" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                          d="M4 6h16M4 12h16M4 18h16"/>
                    <path x-show="open" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                          d="M6 18L18 6M6 6l12 12"/>
                </svg>
            </button>

            {{-- Logo --}}
            <a href="{{ route('home') }}" class="flex items-center gap-3">
                <img src="{{ asset('images/logo.png') }}" alt="Logo Farmacheat" class="h-6">
                {{-- [PERBAIKAN 1/2] Hapus 'text-black' dan ganti dengan 'logo-text' --}}
                <span class="text-xl font-bold logo-text">Farmacheat</span>
            </a>

            {{-- Search (desktop) --}}
            @auth
            <form action="{{ route('shop.index') }}" class="hidden md:flex flex-1 max-w-xl ml-4">
                <div class="relative w-full">
                    <input type="text" name="q" value="{{ request('q') }}"
                           placeholder="Cari obat..."
                           class="w-full rounded-full border-gray-200 bg-white/70 pl-10 pr-4 py-2
                                  focus:ring-brand-300 focus:border-brand-400">
                    <svg class="w-5 h-5 absolute left-3 top-1/2 -translate-y-1/2 text-gray-400"
                         fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                              d="m21 21-4.35-4.35M10 18a8 8 0 1 1 0-16 8 8 0 0 1 0 16z"/>
                    </svg>
                </div>
                <button class="btn btn-primary ml-2">Cari</button>
            </form>
            @endauth

            {{-- Right side --}}
            <div class="ml-auto flex items-center gap-3">
                {{-- Tombol Dark Mode --}}
                <button id="theme-toggle" type="button" class="text-gray-500 dark:text-gray-400 hover:bg-gray-100 dark:hover:bg-gray-700 focus:outline-none focus:ring-4 focus:ring-gray-200 dark:focus:ring-gray-700 rounded-lg text-sm p-2.5">
                    <svg id="theme-toggle-dark-icon" class="hidden w-5 h-5" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg"><path d="M17.293 13.293A8 8 0 016.707 2.707a8.001 8.001 0 1010.586 10.586z"></path></svg>
                    <svg id="theme-toggle-light-icon" class="hidden w-5 h-5" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg"><path d="M10 2a1 1 0 011 1v1a1 1 0 11-2 0V3a1 1 0 011-1zm4 8a4 4 0 11-8 0 4 4 0 018 0zm-.464 4.95l.707.707a1 1 0 001.414-1.414l-.707-.707a1 1 0 00-1.414 1.414zm2.12-10.607a1 1 0 010 1.414l-.706.707a1 1 0 11-1.414-1.414l.707-.707a1 1 0 011.414 0zM17 11a1 1 0 100-2h-1a1 1 0 100 2h1zm-7 4a1 1 0 011 1v1a1 1 0 11-2 0v-1a1 1 0 011-1zM5.05 6.464A1 1 0 106.465 5.05l-.708-.707a1 1 0 00-1.414 1.414l.707.707zm1.414 8.486l-.707.707a1 1 0 01-1.414-1.414l.707-.707a1 1 0 011.414 1.414zM4 11a1 1 0 100-2H3a1 1 0 100 2h1z" fill-rule="evenodd" clip-rule="evenodd"></path></svg>
                </button>

                @auth
                    @if(Auth::user()->role === 'admin')
                        <a href="{{ route('admin.dashboard') }}" class="btn btn-white">Admin</a>
                    @else
                        <a href="{{ route('shop.cart.index') }}" class="btn btn-white">Cart</a>
                        <a href="{{ route('shop.orders.index') }}" class="btn btn-white">Pesanan</a>
                    @endif

                    {{-- Tombol logout langsung (POST) --}}
                    <form method="POST" action="{{ route('logout') }}">
                        @csrf
                        <button type="submit" class="btn btn-white">Log Out</button>
                    </form>

                    {{-- Dropdown akun (opsional) --}}
                    <x-dropdown align="right" width="48">
                        <x-slot name="trigger">
                            {{-- [PERBAIKAN 2/2] Tambahkan class "account-trigger" di sini --}}
                            <button
                                class="hidden md:inline-flex items-center rounded-full bg-white px-3 py-2 border hover:bg-brand-50 account-trigger">
                                <div>{{ Auth::user()->name ?? 'Account' }}</div>
                                <div class="ms-1">
                                    <svg class="h-4 w-4" xmlns="http://www.w3.org/2000/svg"
                                         fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                              d="M19 9l-7 7-7-7" />
                                    </svg>
                                </div>
                            </button>
                        </x-slot>

                        <x-slot name="content">
                            @if (Route::has('profile.edit'))
                                <x-dropdown-link :href="route('profile.edit')">Profile</x-dropdown-link>
                            @endif
                            <form method="POST" action="{{ route('logout') }}">
                                @csrf
                                <x-dropdown-link :href="route('logout')"
                                        onclick="event.preventDefault(); this.closest('form').submit();">
                                    Log Out
                                </x-dropdown-link>
                            </form>
                        </x-slot>
                    </x-dropdown>
                @else
                    <a href="{{ route('login') }}" class="btn btn-primary">Login</a>
                @endauth
            </div>
        </div>

        {{-- Mobile panel --}}
        <div x-show="open" x-cloak class="md:hidden pb-3">
            @auth
                <div class="pt-2 flex flex-col gap-2">
                    @if(Auth::user()->role === 'admin')
                        <a href="{{ route('admin.dashboard') }}" class="btn btn-white w-full text-left">Admin</a>
                    @else
                        <a href="{{ route('shop.index') }}" class="btn btn-white w-full text-left">Shop</a>
                        <a href="{{ route('shop.cart.index') }}" class="btn btn-white w-full text-left">Cart</a>
                        <a href="{{ route('shop.orders.index') }}" class="btn btn-white w-full text-left">Pesanan</a>
                    @endif
                    <form method="POST" action="{{ route('logout') }}">
                        @csrf
                        <button class="btn btn-white w-full text-left">Log Out</button>
                    </form>
                </div>
            @else
                <div class="pt-2">
                    <a href="{{ route('login') }}" class="btn btn-primary w-full">Login</a>
                </div>
            @endauth
        </div>
    </div>
</nav>