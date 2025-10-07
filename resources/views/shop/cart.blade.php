<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center justify-between">
            <h2 class="text-2xl font-semibold text-gray-800 dark:text-slate-200">Keranjang Belanja</h2>
            <a href="{{ route('shop.index') }}" class="btn btn-white">← Lanjut Belanja</a>
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="space-y-6">
                {{-- Session Messages --}}
                @if (session('success'))
                    <div class="p-4 bg-green-50 border-l-4 border-green-400 text-green-800 rounded-r-lg dark:bg-green-900/30 dark:border-green-600 dark:text-green-300">
                        <p>{{ session('success') }}</p>
                    </div>
                @endif
                @if (session('error'))
                    <div class="p-4 bg-red-50 border-l-4 border-red-400 text-red-800 rounded-r-lg dark:bg-red-900/30 dark:border-red-600 dark:text-red-300">
                        <p>{{ session('error') }}</p>
                    </div>
                @endif

                @if (count($items) === 0)
                    {{-- Tampilan Keranjang Kosong --}}
                    <div class="bg-white dark:bg-slate-800 shadow-lg rounded-lg p-8 text-center">
                        <h3 class="text-xl font-semibold text-gray-700 dark:text-slate-300">Keranjang Anda Kosong</h3>
                        <p class="text-gray-500 dark:text-slate-400 mt-2">Sepertinya Anda belum menambahkan obat apapun ke keranjang.</p>
                        <a href="{{ route('shop.index') }}" class="mt-6 inline-block px-6 py-2 bg-cyan-500 text-white font-bold rounded-lg shadow-md hover:bg-cyan-600 transition-colors">
                            Mulai Belanja
                        </a>
                    </div>
                @else
                    {{-- Notifikasi Obat Resep --}}
                    @if ($hasRx)
                        <div class="p-4 bg-amber-50 border-l-4 border-amber-400 text-amber-800 rounded-r-lg dark:bg-amber-900/30 dark:border-amber-600 dark:text-amber-300">
                            <p class="font-bold">Mengandung Obat Resep</p>
                            <p class="text-sm">Pesanan akan diproses setelah resep dokter disetujui.</p>
                        </div>
                    @endif

                    <div class="bg-white dark:bg-slate-800 shadow-lg rounded-lg overflow-hidden">
                        {{-- Tabel Item --}}
                        <div class="overflow-x-auto">
                            <table class="min-w-full divide-y divide-gray-200 dark:divide-slate-700">
                                <thead class="bg-gray-50 dark:bg-slate-900">
                                    <tr>
                                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-slate-400 uppercase tracking-wider">Obat</th>
                                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-slate-400 uppercase tracking-wider">Kuantitas</th>
                                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-slate-400 uppercase tracking-wider">Harga Satuan</th>
                                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-slate-400 uppercase tracking-wider">Subtotal</th>
                                        <th scope="col" class="relative px-6 py-3"><span class="sr-only">Hapus</span></th>
                                    </tr>
                                </thead>
                                <tbody class="bg-white dark:bg-slate-800 divide-y divide-gray-200 dark:divide-slate-700">
                                    @foreach($items as $it)
                                        <tr>
                                            <td class="px-6 py-4 whitespace-nowrap">
                                                <div class="text-sm font-medium text-gray-900 dark:text-slate-200">
                                                    <a href="{{ route('shop.product.show',$it['slug']) }}" class="text-cyan-600 hover:text-cyan-800 dark:text-cyan-400 dark:hover:text-cyan-300">{{ $it['name'] }}</a>
                                                </div>
                                                @if($it['is_rx'])
                                                    <div class="text-xs text-red-600 dark:text-red-400">Perlu Resep</div>
                                                @endif
                                            </td>
                                            <td class="px-6 py-4 whitespace-nowrap">
                                                <form method="POST" action="{{ route('shop.cart.update') }}" class="flex items-center gap-2">
                                                    @csrf
                                                    <input type="hidden" name="id" value="{{ $it['id'] }}">
                                                    <input type="number" name="qty" value="{{ $it['qty'] }}" min="1" class="w-20 border-gray-300 rounded-md shadow-sm focus:ring-cyan-500 focus:border-cyan-500 text-sm">
                                                    <button class="btn btn-white">Update</button>
                                                </form>
                                            </td>
                                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500 dark:text-slate-400">Rp {{ number_format($it['price'],0,',','.') }}</td>
                                            <td class="px-6 py-4 whitespace-nowrap text-sm font-semibold text-gray-800 dark:text-slate-200">Rp {{ number_format($it['price']*$it['qty'],0,',','.') }}</td>
                                            <td class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium">
                                                <form method="POST" action="{{ route('shop.cart.remove') }}">
                                                    @csrf
                                                    <input type="hidden" name="id" value="{{ $it['id'] }}">
                                                    <button type="submit" class="px-3 py-1 bg-red-600 text-white text-xs font-semibold rounded-md hover:bg-red-700 transition-colors">Hapus</button>
                                                </form>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>

                        <div class="bg-gray-50 dark:bg-slate-900 px-6 py-6 flex items-center justify-between">
                            <form method="POST" action="{{ route('shop.cart.clear') }}">
                                @csrf
                                <button class="btn btn-white">Kosongkan Keranjang</button>
                            </form>
                            <div class="text-right">
                                <div class="text-sm text-gray-600 dark:text-slate-400">Total Belanja</div>
                                <div class="text-xl font-bold text-gray-900 dark:text-slate-200 mb-4">Rp {{ number_format($total,0,',','.') }}</div>
                                <a href="{{ route('shop.checkout.show') }}" class="btn btn-white">Lanjut ke Checkout</a>
                            </div>
                        </div>
                    </div>
                @endif
            </div>
        </div>
    </div>
</x-app-layout>
