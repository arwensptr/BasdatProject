<!DOCTYPE html>
<html lang="<?php echo e(str_replace('_', '-', app()->getLocale())); ?>" class="scroll-smooth">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Farmacheat - Apotek Online Terpercaya</title>
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=instrument-sans:400,500,600,700" rel="stylesheet" />
    <?php echo app('Illuminate\Foundation\Vite')(['resources/css/app.css', 'resources/js/app.js']); ?>

    <style>
        body {
            font-family: 'Instrument Sans', sans-serif;
            background-image: url('<?php echo e(asset('images/login-bg.jpg')); ?>');
            background-size: cover;
            background-position: center;
            background-attachment: fixed;
        }

        /* spacing global */
        h1, h2, p { margin-bottom: 26px; }

        /* Feature section */
        .feature-grid {
            display: grid;
            grid-template-columns: 1fr;
            gap: 2.5rem;
        }
        @media (min-width: 640px) {
            .feature-grid { grid-template-columns: repeat(3, 1fr); }
        }

        .feature-box {
            background: rgba(255, 255, 255, 0.75);
            backdrop-filter: blur(6px);
            border-radius: 20px;
            padding: 32px;
            box-shadow: 0 4px 12px rgba(0,0,0,0.15);
        }

        .feature-header {
            display: flex;
            align-items: center;
            gap: 12px;
            background: #2563eb;
            color: white;
            padding: 12px 16px;
            border-radius: 14px;
            font-size: 18px;
            font-weight: 600;
            margin-bottom: 24px;
        }

        .icon {
            width: 24px;
            height: 24px;
        }

        .feature-text {
            color: #000;
            font-size: 16px;
            line-height: 1.75;
        }

        /* Better spacing for hero section */
        .hero-section h1 { margin-bottom: 32px; }
        .hero-section p { margin-bottom: 32px; }
        .hero-section a { margin-top: 24px; }
    </style>
</head>
<body class="antialiased text-slate-800">

    <header class="sticky top-0 z-50 w-full bg-white/80 backdrop-blur-sm shadow-sm">
        <div class="container mx-auto flex items-center justify-between p-6">
            <a href="/" class="flex items-center gap-3">
                <img src="<?php echo e(asset('images/logo.png')); ?>" alt="Logo Farmacheat" class="h-8">
                <span class="font-bold text-xl text-slate-900">Farmacheat</span>
            </a>
            <nav class="hidden items-center gap-4 text-md md:flex">
                <?php if(Route::has('login')): ?>
                    <?php if(auth()->guard()->check()): ?>
                        <a href="<?php echo e(url('/dashboard')); ?>" class="font-semibold text-slate-600 hover:text-blue-600">Dashboard</a>
                    <?php else: ?>
                        <a href="<?php echo e(route('login')); ?>" class="font-semibold text-slate-600 hover:text-blue-600">Log in</a>
                        <?php if(Route::has('register')): ?>
                            <a href="<?php echo e(route('register')); ?>" class="rounded-full bg-blue-600 px-5 py-2 font-semibold text-white transition hover:bg-blue-700">Register</a>
                        <?php endif; ?>
                    <?php endif; ?>
                <?php endif; ?>
            </nav>
        </div>
    </header>

    <main>
        <!-- HERO SECTION -->
        <section class="hero-section flex min-h-screen flex-col items-center justify-center px-4 text-center">
            <div class="max-w-4xl">
                <h1 class="text-4xl font-bold tracking-tight text-slate-900 sm:text-5xl">
                    Apotek Digital Terpercaya di Ujung Jari Anda
                </h1>

                <p class="mt-6 text-xl text-slate-700 md:text-2xl">
                    Solusi Cepat & Terpercaya untuk Kebutuhan Kesehatan Anda. <br>
                    Temukan obat, vitamin, dan berbagai kebutuhan medis lainnya.
                </p>

                <div class="mt-10">
                    <a href="<?php echo e(route('register')); ?>" class="rounded-full bg-blue-600 px-6 py-3 text-lg font-bold text-white transition hover:bg-blue-700">
                        Mulai Sekarang
                    </a>
                </div>
            </div>
        </section>

        <!-- FEATURE SECTION -->
        <section id="features" class="py-24">
            <div class="container mx-auto max-w-7xl px-6 lg:px-8">

                <div class="mx-auto max-w-3xl text-center mb-16">
                    <h2 class="text-3xl font-bold tracking-tight text-slate-900 sm:text-4xl">
                        Kenapa Memilih Farmacheat?
                    </h2>
                    <p class="mt-6 text-xl text-slate-700">
                        Layanan modern, cepat, dan terpercaya untuk kebutuhan kesehatan Anda.
                    </p>
                </div>

                <div class="feature-grid">

                    <!-- Box 1 -->
                    <div class="feature-box">
                        <div class="feature-header">
                            <svg class="icon" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24"><path fill="white" d="M9 16.17 4.83 12l-1.42 1.41L9 19 21 7l-1.41-1.41z"/></svg>
                            Produk Terjamin
                        </div>
                        <p class="feature-text">Semua produk berasal dari distributor resmi dan terjamin keasliannya.</p>
                    </div>

                    <!-- Box 2 -->
                    <div class="feature-box">
                        <div class="feature-header">
                            <svg class="icon" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24"><path fill="white" d="M3 13h1l2-5h11l2 5h1a2 2 0 0 1 0 4h-1a3 3 0 0 1-6 0H9a3 3 0 0 1-6 0H3a2 2 0 0 1 0-4zm4.5 5a1.5 1.5 0 1 0 0-3a1.5 1.5 0 0 0 0 3zm11 0a1.5 1.5 0 1 0 0-3a1.5 1.5 0 0 0 0 3z"/></svg>
                            Pengantaran Cepat
                        </div>
                        <p class="feature-text">Armada pengiriman cepat memastikan pesanan sampai tepat waktu.</p>
                    </div>

                    <!-- Box 3 -->
                    <div class="feature-box">
                        <div class="feature-header">
                            <svg class="icon" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24"><path fill="white" d="M12 1a11 11 0 1 0 0 22a11 11 0 0 0 0-22zm1 11h5v2h-7V6h2v6z"/></svg>
                            Efisiensi Waktu
                        </div>
                        <p class="feature-text">Proses cepat dan rute optimal menjadikan layanan lebih efisien.</p>
                    </div>

                </div>
            </div>
        </section>

        <footer class="relative z-10 border-t border-blue-200 text-slate-700">
            <div class="container mx-auto p-6 text-center">
                <p>&copy; <?php echo e(date('Y')); ?> Farmacheat. All rights reserved.</p>
            </div>
        </footer>
    </main>

<?php /**PATH C:\laragon\www\farmacheat\resources\views/welcome.blade.php ENDPATH**/ ?>