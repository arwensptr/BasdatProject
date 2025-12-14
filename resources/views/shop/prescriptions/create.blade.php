<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center justify-between">
            <h2 class="text-2xl font-semibold text-gray-800 dark:text-slate-200">Upload Resep — Pesanan #{{ $order->id }}</h2>
            <a href="{{ route('shop.orders.show',$order) }}" class="btn btn-white">← Kembali ke Pesanan</a>
        </div>
    </x-slot>

    <div class="py-8">
        <div class="max-w-4xl mx-auto sm:px-6 lg:px-8 space-y-6">
            <div class="p-4 bg-amber-50 border-l-4 border-amber-400 text-amber-800 rounded-r-lg dark:bg-amber-900/30 dark:border-amber-600 dark:text-amber-300">
                <p class="font-bold">Unggah File Resep Anda</p>
                <p class="text-sm">Unggah 1-3 file (JPG, PNG, atau PDF). Setelah terkirim, status pesanan akan ditinjau oleh admin kami.</p>
            </div>

            <div class="bg-white dark:bg-slate-800 shadow-lg rounded-lg">
                <form method="POST" action="{{ route('shop.prescriptions.store',$order) }}" enctype="multipart/form-data">
                    @csrf
                    <div class="p-8 space-y-6">
                        <div>
                            <label for="file-upload" class="btn btn-white w-full h-32 flex flex-col items-center justify-center border-2 border-dashed border-gray-300 dark:border-slate-600 rounded-lg cursor-pointer hover:bg-gray-50 dark:hover:bg-slate-700">
                                <span class="flex items-center space-x-2">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="w-6 h-6 text-gray-600 dark:text-slate-400" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-8l-4-4m0 0L8 8m4-4v12" />
                                    </svg>
                                    <span class="font-medium text-gray-600 dark:text-slate-400">
                                        Seret & lepas file, atau
                                        <span class="text-cyan-600 dark:text-cyan-400 underline">klik untuk memilih</span>
                                    </span>
                                </span>
                                <span id="file-names-display" class="text-sm text-gray-500 dark:text-slate-500 mt-2"></span>
                            </label>
                            <input id="file-upload" type="file" name="files[]" multiple class="sr-only" required>
                            @error('files.*')<div class="text-red-600 text-sm mt-1">{{ $message }}</div>@enderror
                        </div>

                        <div>
                            <label for="note" class="block text-sm font-medium text-gray-700 dark:text-slate-300 mb-1">Catatan (opsional)</label>
                            <textarea name="note" id="note" rows="3" class="w-full rounded-lg border-gray-200 bg-gray-50 text-sm shadow-sm focus:border-cyan-500 focus:ring-cyan-500" placeholder="Tinggalkan catatan untuk apoteker jika ada...">{{ old('note',$prescription->note ?? '') }}</textarea>
                            @error('note')<div class="text-red-600 text-sm mt-1">{{ $message }}</div>@enderror
                        </div>
                    </div>
                    
                    <div class="bg-gray-50 dark:bg-slate-900 px-6 py-6 flex items-center justify-end gap-4 rounded-b-lg">
                        <a href="{{ route('shop.orders.show',$order) }}" class="btn btn-white">Batal</a>
                        <button type="submit" class="btn btn-primary">Kirim Resep</button>
                    </div>
                </form>
            </div>

            @if(!empty($prescription) && !empty($prescription->attachments))
                <div class="bg-white dark:bg-slate-800 shadow-lg rounded-lg p-6">
                    <h3 class="text-xl font-semibold mb-4 border-b pb-3 dark:text-slate-200 dark:border-slate-700">Lampiran Terkirim</h3>
                    <ul class="space-y-2">
                        @foreach((array) ($prescription->attachments ?? []) as $p)
                            <li>
                                <a href="{{ asset('storage/'.$p) }}" target="_blank" class="flex items-center gap-2 text-cyan-700 dark:text-cyan-400 hover:underline">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13.828 10.172a4 4 0 00-5.656 0l-4 4a4 4 0 105.656 5.656l1.102-1.101m-.758-4.899a4 4 0 005.656 0l4-4a4 4 0 00-5.656-5.656l-1.1 1.1" /></svg>
                                    <span>{{ basename($p) }}</span>
                                </a>
                            </li>
                        @endforeach
                    </ul>
                </div>
            @endif
        </div>
    </div>

    <script>
        const fileInput = document.getElementById('file-upload');
        const fileNamesDisplay = document.getElementById('file-names-display');
        fileInput.addEventListener('change', function() {
            if (this.files.length > 0) {
                let fileNames = Array.from(this.files).map(file => file.name).join(', ');
                fileNamesDisplay.textContent = fileNames;
            } else {
                fileNamesDisplay.textContent = '';
            }
        });
    </script>
</x-app-layout>
