<x-app-layout>
  <x-slot name="header"><h2 class="text-2xl font-semibold">Stok Obat</h2></x-slot>

  <div class="admin-grid section">
    @include('admin.partials.sidebar')

    <div class="section">
      @if(session('success')) <div class="card pad text-emerald-700">{{ session('success') }}</div> @endif
      @if(session('error'))   <div class="card pad text-red-700">{{ session('error') }}</div> @endif

      {{-- KOTAK KONTROL: CARI & TAMBAH OBAT --}}
      <div class="card pad mb-4">
        <div class="flex items-center justify-between">
          {{-- FORM PENCARIAN OBAT --}}
          <form method="GET" action="{{ route('admin.medicines.index') }}">
            <div class="flex items-center gap-2">
              <input type="text" name="q" value="{{ request('q') }}" placeholder="Cari nama obat..." class="w-full rounded-lg border-gray-300">
              <button type="submit" class="btn btn-primary">Cari</button>
            </div>
          </form>
          {{-- TOMBOL TAMBAH OBAT --}}
          <a href="{{ route('admin.medicines.create') }}" class="btn btn-primary">+ Tambah Obat</a>
        </div>
      </div>

      <div class="table-wrap">
        <table class="min-w-full text-sm table-ui">
          <thead>
            <tr>
              <th class="w-20">Gambar</th>
              <th>Obat</th>
              <th>Kategori</th>
              <th class="text-right">Harga</th>
              <th class="text-center">Resep</th>
              <th class="text-center">Stok</th>
              <th>Tambah Stok</th>
              <th>Aksi</th>
            </tr>
          </thead>
          <tbody class="divide-y">
            @forelse($medicines as $m)
              <tr class="hover:bg-brand-50/30">
                <td>
                  <img src="{{ $m->image ? asset('storage/' . $m->image) : 'https://via.placeholder.com/100' }}" alt="{{ $m->name }}" class="w-16 h-16 object-cover rounded-md">
                </td>
                <td class="w-24 font-medium">{{ $m->name }}</td>
                <td class="w-24 text-center">{{ $m->category->name ?? '-' }}</td>
                <td class="w-24 text-right">Rp {{ number_format($m->price,0,',','.') }}</td>
                <td class="w-24 text-center">
                  @if($m->is_prescription_only)
                    <span class="w-24 badge-rx">Perlu Resep</span>
                  @else
                    <span class="w-24 badge-ok">Bebas</span>
                  @endif
                </td>
                <td class="text-center font-semibold">{{ $m->stock }}</td>
                <td>
                  <form method="POST" action="{{ route('admin.medicines.addStock', $m) }}" class="flex items-center gap-2">
                    @csrf
                    <input type="number" name="qty" min="1" value="1" class="w-16 border rounded-xl px-3 py-2">
                    <button class="btn btn-primary px-3 py-2">Tambah <br> Stok</button>
                  </form>
                </td>
                <td>
                  <a href="{{ route('admin.medicines.edit', $m) }}" class="btn btn-primary px-3 py-2">Edit
                  </a>
                </td>
              </tr>
            @empty
              {{-- PESAN INI AKAN MUNCUL JIKA OBAT TIDAK DITEMUKAN ATAU TABEL KOSONG --}}
              <tr>
                <td colspan="8" class="py-6 text-center text-gray-500">
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

      {{-- JANGAN LUPA: Tambahkan links() agar paginasi tetap berfungsi dengan pencarian --}}
      @if ($medicines->hasPages())
        <div class="mt-4">
          {{ $medicines->links() }}
        </div>
      @endif

    </div>
  </div>
</x-app-layout>