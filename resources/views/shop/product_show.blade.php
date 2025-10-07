<x-app-layout>
    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 md:p-8 text-gray-900">

                    {{-- Breadcrumb atau Link Kembali --}}
                    <div class="mb-6">
                        <a href="{{ route('shop.index') }}" class="text-indigo-600 hover:text-indigo-800 font-semibold">
                            &larr; Kembali ke Katalog
                        </a>
                    </div>

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
                        {{-- Kolom Gambar --}}
                        <div>
                            <img src="{{ asset('storage/' . $medicine->image) }}" alt="{{ $medicine->name }}"
                                 class="w-78 h-auto rounded-lg shadow-md object-cover">
                        </div>

                        {{-- Kolom Detail Obat --}}
                        <div>
                            <h1 class="text-3xl font-bold text-gray-800 mb-2">
                                {{ $medicine->name }}
                            </h1>
                            
                            @if($medicine->category)
                                <span class="inline-block bg-gray-200 text-gray-700 text-sm font-semibold px-3 py-1 rounded-full mb-4">
                                    {{ $medicine->category->name }}
                                </span>
                            @endif

                            <p class="text-2xl font-semibold text-indigo-600 mb-4">
                                Rp {{ number_format($medicine->price, 0, ',', '.') }}
                            </p>

                            <h2 class="text-xl font-semibold mt-6 mb-2">Deskripsi</h2>
                            <div class="text-gray-600 leading-relaxed">
                                {!! nl2br(e($medicine->description)) !!}
                            </div>

                            <div class="mt-8">
                                <button class="w-full bg-indigo-600 text-white font-bold py-3 px-6 rounded-lg hover:bg-indigo-700 transition-colors duration-300">
                                    Tambah ke Keranjang
                                </button>
                            </div>
                        </div>
                    </div>

                </div>
            </div>
        </div>
    </div>
</x-app-layout>