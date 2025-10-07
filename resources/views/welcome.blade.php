<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" class="scroll-smooth">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Farmacheat - Apotek Online Terpercaya</title>
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=instrument-sans:400,500,600,700" rel="stylesheet" />
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <style>
        body {
            font-family: 'Instrument Sans', sans-serif;
            background-image: url('{{ asset('images/login-bg.jpg') }}');
            background-size: cover;       /* biar gambar nutup seluruh layar */
            background-position: center;  /* posisi di tengah */
            background-attachment: fixed; /* biar ikut scroll */
        }
            /* EFEK KACA DENGAN BLUR YANG LEBIH TIPIS */
        .glass-effect {
            background: rgba(255, 255, 255, 0.25);
            backdrop-filter: blur(4px); /* <-- BLUR DIKURANGI JADI 4PX */
            -webkit-backdrop-filter: blur(4px);
            border: 1px solid rgba(255, 255, 255, 0.18);
        }

        /* KELAS BARU UNTUK MEMAKSA JARAK ANTAR BOX */
        .feature-grid {
            display: grid;
            gap: 2.5rem; /* <-- INI YANG AKAN MEMBUAT JARAK ANTAR BOX */
    }
    </style>
</head>
<body class="antialiased text-slate-800">

    <header class="sticky top-0 z-50 w-full bg-white/80 backdrop-blur-sm shadow-sm">
        <div class="container mx-auto flex items-center justify-between p-6">
            <a href="/" class="flex items-center gap-3">
                <img src="{{ asset('images/logo.png') }}" alt="Logo Farmacheat" class="h-8">
                <span class="font-bold text-xl text-slate-900">Farmacheat</span>
            </a>
            <nav class="hidden items-center gap-4 text-md md:flex">
                @if (Route::has('login'))
                    @auth
                        <a href="{{ url('/dashboard') }}" class="font-semibold text-slate-600 hover:text-blue-600">Dashboard</a>
                    @else
                        <a href="{{ route('login') }}" class="font-semibold text-slate-600 hover:text-blue-600">Log in</a>
                        @if (Route::has('register'))
                            <a href="{{ route('register') }}" class="rounded-full bg-blue-600 px-5 py-2 font-semibold text-white transition hover:bg-blue-700">Register</a>
                        @endif
                    @endauth
                @endif
            </nav>
        </div>
    </header>

    <main>
        <section class="flex min-h-screen flex-col items-center justify-center p-4">
            <div class="max-w-4xl text-center">
                <h1 class="text-3xl font-bold tracking-tight text-slate-900 sm:text-4xl">
                    Apotek Digital Terpercaya di Ujung Jari Anda
                </h1>
                <p class="mt-4 text-xl text-slate-700 md:text-2xl">
                    Solusi Cepat & Terpercaya untuk Kebutuhan Kesehatan Anda. <br>
                    Temukan obat, vitamin, dan obat jenis lainnya dengan mudah.
                </p>
                <br>
                <div class="mt-8">
                    <a href="{{ route('register') }}" class="rounded-full bg-blue-600 px-5 py-2 text-lg font-bold text-white transition hover:bg-blue-700">
                        Mulai Sekarang
                    </a>
                </div>
            </div>
        </section>

        <section id="features" class="py-20 sm:py-24">
            <div class="container mx-auto max-w-7xl px-6 lg:px-8">
                <div class="mx-auto max-w-4xl text-center">
                    <h2 class="text-3xl font-bold tracking-tight text-slate-900 sm:text-4xl">Kenapa Memilih Farmacheat?</h2>
                    <p class="mt-6 text-xl text-slate-700">
                        Kami menyediakan layanan terbaik untuk memastikan kesehatan Anda selalu terjaga.
                    </p>
                </div>
                
                <div class="feature-grid mx-auto mt-16 grid-cols-1 text-center sm:grid-cols-3">
                    
                    <div class="glass-effect rounded-xl p-8 shadow-lg transition-transform hover:-translate-y-2">
                        <div class="mx-auto flex h-12 w-12 items-center justify-center rounded-lg bg-gradient-to-br from-blue-500 to-blue-700 shadow-md">
                            <svg class="h-6 w-6 text-white" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" d="M9 12.75L11.25 15 15 9.75m-3-7.036A11.959 11.959 0 013.598 6 11.99 11.99 0 003 9.749c0 5.592 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.31-.21-2.571-.598-3.751h-.152c-3.196 0-6.1-1.248-8.25-3.286zm0 13.036h.008v.016h-.008v-.016z" /></svg>
                        </div>
                        <h3 class="mt-5 text-xl font-semibold text-slate-900">Produk Lengkap & Terjamin</h3>
                        <p class="mt-2 text-slate-700">
                            Semua produk kami berasal dari distributor resmi dan terjamin keasliannya.
                        </p>
                    </div>

                    <div class="glass-effect rounded-xl p-8 shadow-lg transition-transform hover:-translate-y-2">
                        <div class="mx-auto flex h-12 w-12 items-center justify-center rounded-lg bg-gradient-to-br from-blue-500 to-blue-700 shadow-md">
                            <svg class="h-6 w-6 text-white" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor"><path d="M8.25 18.75a1.5 1.5 0 01-3 0m3 0a1.5 1.5 0 00-3 0m3 0h6m-9 0H3.375a1.125 1.125 0 01-1.125-1.125V14.25m17.25 4.5a1.5 1.5 0 01-3 0m3 0a1.5 1.5 0 00-3 0m3 0h1.125c.621 0 1.125-.504 1.125-1.125V14.25m-17.25 4.5v-1.875a3.375 3.375 0 003.375-3.375h1.5a1.125 1.125 0 011.125 1.125v-1.5c0-.621-.504-1.125-1.125-1.125H3.375m17.25 4.5v-1.875a3.375 3.375 0 00-3.375-3.375h-1.5a1.125 1.125 0 00-1.125 1.125v1.5c0 .621.504 1.125 1.125 1.125h1.5m-17.25-4.5h9.75v-4.5H3.375z" /></svg>
                        </div>
                        <h3 class="mt-5 text-xl font-semibold text-slate-900">Pesan Antar Cepat & Mudah</h3>
                        <p class="mt-2 text-slate-700">
                            Pesan dari rumah dan kami akan antarkan pesanan Anda dengan cepat dan aman.
                        </p>
                    </div>

                    <div class="glass-effect rounded-xl p-8 shadow-lg transition-transform hover:-translate-y-2">
                        <div class="mx-auto flex h-12 w-12 items-center justify-center rounded-lg bg-gradient-to-br from-blue-500 to-blue-700 shadow-md">
                        <svg class="h-6 w-6 text-white" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" d="M20.25 8.511c.884.284 1.5 1.128 1.5 2.097v4.286c0 1.136-.847 2.1-1.98 2.193l-3.72-3.72a1.5 1.5 0 01-2.122 0l-3.72-3.72a1.5 1.5 0 010-2.122l3.72-3.72a1.5 1.5 0 012.122 0l3.72 3.72zM15.75 12h.008v.008h-.008V12zM12.75 15h.008v.008h-.008V15zM10.5 12h.008v.008h-.008V12zM7.5 15h.008v.008h-.008V15zM4.5 12h.008v.008h-.008V12zM12 18.75a6 6 0 00-5.992-5.996l-3.72-3.72a1.5 1.5 0 000-2.122l3.72-3.72A6 6 0 0012 2.252a6 6 0 005.992 5.996l3.72 3.72a1.5 1.5 0 000 2.122l-3.72 3.72A6 6 0 0012 18.75z" /></svg>
                        </div>
                        <h3 class="mt-5 text-xl font-semibold text-slate-900">Mudah dan Praktis</h3>
                        <p class="mt-2 text-slate-700">
                            Ada resep dan tidak sempat ke apotek? Langsung saja pesan dari kami.
                        </p>
                    </div>
                </div>
            </div>
        </section>
        
        <footer class="relative z-10 border-t border-blue-200 text-slate-700">
            <div class="container mx-auto p-6 text-center">
                <p>&copy; {{ date('Y') }} Farmacheat. All rights reserved.</p>
            </div>
        </footer>
    </main>

</body>
</html>