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
                            <div class="text-sm text-gray-600 dark:text-slate-400 mb-2">Stok tersedia: {{ $medicine->stock ?? 0 }}</div>

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
                                <form method="POST" action="{{ route('shop.cart.add') }}" class="flex gap-2" id="add-to-cart-form">
                                    @csrf
                                    <input type="hidden" name="slug" value="{{ $medicine->slug }}">
                                    <input type="number" name="qty" value="1" min="1" max="{{ $medicine->stock ?? 0 }}" class="w-20 border rounded-lg px-2 py-1 border-gray-300 dark:bg-slate-900 dark:border-slate-700" id="product-qty-input">
                                    {{-- [FIX] Menggunakan class .btn-primary --}}
                                    <button class="btn btn-primary">Tambah ke Keranjang</button>
                                </form>

                                <div id="product-error" class="hidden p-3 mt-3 bg-red-50 border-l-4 border-red-400 text-red-800 rounded-r-lg dark:bg-red-900/30 dark:border-red-600 dark:text-red-300 transition-all duration-300 transform -translate-y-2 opacity-0">
                                    <div class="flex items-start justify-between gap-4">
                                        <p id="product-error-text" class="flex-1"></p>
                                        <button type="button" id="product-error-close" class="text-red-600 hover:text-red-800">&times;</button>
                                    </div>
                                </div>

                                {{-- [BARU] Tombol untuk melihat keranjang --}}
                                <a href="{{ route('shop.cart.index') }}" class="btn btn-white">Lihat Keranjang</a>
                            </div>
                        </div>
                    </div>

                    <script>
                        document.addEventListener('DOMContentLoaded', function(){
                            const form = document.getElementById('add-to-cart-form');
                            const input = document.getElementById('product-qty-input');
                            const stock = parseInt('{{ $medicine->stock ?? 0 }}', 10);
                            const errEl = document.getElementById('product-error');
                            const errText = document.getElementById('product-error-text');
                            const errClose = document.getElementById('product-error-close');
                            function showProductError(msg){
                                if (!errEl || !errText) return;
                                errText.textContent = msg;
                                errEl.classList.remove('hidden');
                                void errEl.offsetWidth;
                                errEl.classList.remove('-translate-y-2','opacity-0');
                                clearTimeout(errEl._hideTimeout);
                                errEl._hideTimeout = setTimeout(()=>{
                                    errEl.classList.add('-translate-y-2','opacity-0');
                                    setTimeout(()=> errEl.classList.add('hidden'), 300);
                                }, 5000);
                                errEl.scrollIntoView({behavior:'smooth', block:'center'});
                            }
                            if (!form || !input) return;
                            form.addEventListener('submit', function(e){
                                const val = parseInt(input.value||'0',10);
                                if (val > stock) {
                                    e.preventDefault();
                                    showProductError('maaf stock tidak mencukupi');
                                }
                            });
                            if (errClose) errClose.addEventListener('click', function(){
                                if (!errEl) return;
                                clearTimeout(errEl._hideTimeout);
                                errEl.classList.add('-translate-y-2','opacity-0');
                                setTimeout(()=> errEl.classList.add('hidden'), 300);
                            });
                        });
                    </script>

                </div>
            </div>
        </div>
    </div>
</x-app-layout>

