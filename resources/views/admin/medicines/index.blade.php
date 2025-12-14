<x-app-layout>
    <x-slot name="header">
        <h2 class="text-2xl font-semibold dark:text-slate-200">Stok Obat</h2>
    </x-slot>

    <div class="admin-grid section">
        @include('admin.partials.sidebar')

        <div class="section">
            @if(session('success')) <div class="card pad text-emerald-700 dark:bg-emerald-900/50 dark:text-emerald-300">{{ session('success') }}</div> @endif
            @if(session('error'))   <div class="card pad text-red-700 dark:bg-red-900/50 dark:text-red-300">{{ session('error') }}</div> @endif

            <div class="card pad mb-4">
                <div class="flex items-center justify-between">
                    <form method="GET" action="{{ route('admin.medicines.index') }}">
                        <div class="flex items-center gap-2">
                            <input type="text" name="q" value="{{ request('q') }}" placeholder="Cari nama obat..." class="w-full rounded-lg border-gray-300 dark:bg-slate-900 dark:border-slate-700">
                            <button type="submit" class="btn btn-primary">Cari</button>
                        </div>
                    </form>
                    <a href="{{ route('admin.medicines.create') }}" class="btn btn-primary">+ Tambah Obat</a>
                </div>
            </div>

            <div class="table-wrap">
                <table class="min-w-full text-sm table-ui">
                    <thead class="bg-gray-50 dark:bg-slate-700">
                        <tr>
                            <th class="px-4 py-3 text-left text-gray-600 dark:text-slate-300 w-20">Gambar</th>
                            <th class="px-4 py-3 text-left text-gray-600 dark:text-slate-300">Obat</th>
                            <th class="px-4 py-3 text-left text-gray-600 dark:text-slate-300">Kategori</th>
                            {{-- [FIX] Mengembalikan kolom Harga dan Resep menjadi terpisah --}}
                            <th class="px-4 py-3 text-right text-gray-600 dark:text-slate-300">Harga</th>
                            <th class="px-4 py-3 text-center text-gray-600 dark:text-slate-300">Resep</th>
                            <th class="px-4 py-3 text-center text-gray-600 dark:text-slate-300">Stok</th>
                            <th class="px-4 py-3 text-left text-gray-600 dark:text-slate-300">Tambah Stok</th>
                            <th class="px-4 py-3 text-left text-gray-600 dark:text-slate-300">Aksi</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y dark:divide-slate-700">
                        @forelse($medicines as $m)
                            <tr class="hover:bg-brand-50/30 dark:hover:bg-slate-700/50">
                                <td class="px-4 py-3">
                                    <img src="{{ $m->image ? asset('storage/' . $m->image) : 'https://placehold.co/100x100/e2e8f0/e2e8f0' }}" alt="{{ $m->name }}" class="w-16 h-16 object-cover rounded-md">
                                </td>
                                <td class="px-4 py-3 font-medium dark:text-slate-200">{{ $m->name }}</td>
                                <td class="px-4 py-3 text-left dark:text-slate-300">{{ $m->category->name ?? '-' }}</td>
                                <td class="px-4 py-3 text-right dark:text-slate-300 whitespace-nowrap">Rp {{ number_format($m->price,0,',','.') }}</td>
                                
                                <td class="px-4 py-3 text-center whitespace-nowrap">
                                    @if($m->is_prescription_only)
                                        <span class="badge-rx">Perlu Resep</span>
                                    @else
                                        <span class="badge-ok">Bebas</span>
                                    @endif
                                </td>
                                <td class="px-4 py-3 text-center font-semibold dark:text-slate-200">{{ $m->stock }}</td>
                                <td class="px-4 py-3">
                                    <form method="POST" action="{{ route('admin.medicines.addStock', $m) }}" class="flex items-center gap-2">
                                        @csrf
                                        <input type="number" name="qty" min="1" value="1" class="w-16 border rounded-xl px-3 py-2 dark:bg-slate-900 dark:border-slate-700">
                                        <button class="btn btn-primary px-3 py-2">Tambah Stok</button>
                                    </form>
                                </td>
                                <td class="px-4 py-3">
                                    <a href="{{ route('admin.medicines.edit', $m) }}" class="btn btn-primary px-3 py-2">Edit</a>
                                </td>
                            </tr>
                        @empty
                            {{-- [FIX] Mengembalikan colspan ke 8 --}}
                            <tr>
                                <td colspan="8" class="py-6 text-center text-gray-500 dark:text-slate-400">
                                    @if (request('q'))
                                        Obat dengan nama "{{ request('q') }}" tidak ditemukan.
                                    @else
                                        Belum ada data obat.
                                    @endif
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            @if ($medicines->hasPages())
                <div class="mt-4">
                    {{ $medicines->links('vendor.pagination.tailwind') }}
                </div>
            @endif

        </div>
    </div>
</x-app-layout>

