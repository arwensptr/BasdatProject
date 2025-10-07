<x-app-layout>
    {{-- [FIX] Menambahkan gaya dark mode pada header --}}
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight dark:text-slate-200">{{ $medicine->name }}</h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            {{-- [FIX] Mengganti div ini menjadi kartu konten yang sudah mendukung dark mode --}}
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg dark:bg-slate-800 dark:border dark:border-slate-700">
                <div class="p-6 md:p-8 text-gray-900 dark:text-slate-200">

                    {{-- Breadcrumb atau Link Kembali --}}
                    <div class="mb-6">
                        <a href="{{ route('shop.index') }}" class="text-brand-600 hover:text-brand-800 font-semibold dark:text-brand-400 dark:hover:text-brand-300">
                            &larr; Kembali ke Katalog
                        </a>
                    </div>

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
                        {{-- Kolom Gambar --}}
                        <div>
                            <img src="{{ $medicine->image ? asset('storage/' . $medicine->image) : 'https://placehold.co/400x400/e2e8f0/e2e8f0?text=No+Image' }}" alt="{{ $medicine->name }}"
                                 class="w-full h-auto rounded-lg shadow-md object-cover">
                        </div>

                        {{-- Kolom Detail Obat --}}
                        <div>
                            <h1 class="text-3xl font-bold text-gray-800 mb-2 dark:text-white">
                                {{ $medicine->name }}
                            </h1>
                            
                            @if($medicine->category)
                                {{-- [FIX] Menambahkan gaya dark mode pada badge kategori --}}
                                <span class="inline-block bg-gray-200 text-gray-700 text-sm font-semibold px-3 py-1 rounded-full mb-4 dark:bg-slate-700 dark:text-slate-300">
                                    {{ $medicine->category->name }}
                                </span>
                            @endif

                            <p class="text-2xl font-semibold text-brand-600 mb-4 dark:text-brand-400">
                                Rp {{ number_format($medicine->price, 0, ',', '.') }}
                            </p>

                            <h2 class="text-xl font-semibold mt-6 mb-2 dark:text-white">Deskripsi</h2>
                            {{-- [REVISI] Menambahkan class text-justify --}}
                            <div class="text-gray-600 leading-relaxed dark:text-slate-400 text-justify">
                                {!! nl2br(e($medicine->description)) !!}
                            </div>

                            {{-- [FIX] Memperbaiki badge resep --}}
                            <div class="mt-4">
                                @if($medicine->is_prescription_only)
                                    <span class="badge-rx">Perlu Resep</span>
                                @else
                                    <span class="badge-ok">Bebas</span>
                                @endif
                            </div>

                            {{-- [FIX] Mengubah form menjadi flex container --}}
                            <div class="mt-8 flex items-center gap-3">
                                <form method="POST" action="{{ route('shop.cart.add') }}" class="flex gap-2">
                                    @csrf
                                    <input type="hidden" name="slug" value="{{ $medicine->slug }}">
                                    <input type="number" name="qty" value="1" min="1" class="w-20 border rounded-lg px-2 py-1 border-gray-300 dark:bg-slate-900 dark:border-slate-700">
                                    {{-- [FIX] Menggunakan class .btn-primary --}}
                                    <button class="btn btn-primary">Tambah ke Keranjang</button>
                                </form>

                                {{-- [BARU] Tombol untuk melihat keranjang --}}
                                <a href="{{ route('shop.cart.index') }}" class="btn btn-white">Lihat Keranjang</a>
                            </div>
                        </div>
                    </div>

                </div>
            </div>
        </div>
    </div>
</x-app-layout>

