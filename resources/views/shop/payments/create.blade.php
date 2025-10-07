<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center justify-between">
            <h2 class="text-2xl font-semibold text-gray-800 dark:text-slate-200">Upload Bukti Pembayaran — Pesanan #{{ $order->id }}</h2>
            <a href="{{ route('shop.orders.show',$order) }}" class="btn btn-white">← Kembali ke Pesanan</a>
        </div>
    </x-slot>

    <div class="py-8">
        <div class="max-w-4xl mx-auto sm:px-6 lg:px-8 space-y-6">
            <div class="p-4 bg-blue-50 border-l-4 border-blue-400 text-blue-800 rounded-r-lg dark:bg-blue-900/30 dark:border-blue-600 dark:text-blue-300">
                <p class="font-bold">Unggah Bukti Pembayaran</p>
                <p class="text-sm">Silakan transfer sesuai nominal total pesanan. Unggah 1 file bukti transfer (JPG, PNG, atau PDF). Pesanan akan diproses setelah pembayaran diverifikasi.</p>
            </div>

            <div class="bg-white dark:bg-slate-800 shadow-lg rounded-lg">
                <form method="POST" action="{{ route('shop.payments.store',$order) }}" enctype="multipart/form-data">
                    @csrf
                    <div class="p-8">
                        <div>
                            <label for="file-upload" class="btn btn-white w-full h-48 flex flex-col items-center justify-center border-2 border-dashed border-gray-300 dark:border-slate-600 rounded-lg cursor-pointer hover:bg-gray-50 dark:hover:bg-slate-700">
                                <span class="flex items-center space-x-2">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="w-6 h-6 text-gray-600 dark:text-slate-400" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-8l-4-4m0 0L8 8m4-4v12" />
                                    </svg>
                                    <span class="font-medium text-gray-600 dark:text-slate-400">
                                        Seret & lepas file, atau
                                        <span class="text-cyan-600 dark:text-cyan-400 underline">klik untuk memilih</span>
                                    </span>
                                </span>
                                <span id="file-name-display" class="text-sm text-gray-500 dark:text-slate-500 mt-2"></span>
                            </label>
                            <input id="file-upload" type="file" name="file" class="sr-only" required>
                            @error('file')<div class="text-red-600 text-sm mt-1">{{ $message }}</div>@enderror
                        </div>
                    </div>
                    
                    <div class="bg-gray-50 dark:bg-slate-900 px-6 py-6 flex items-center justify-between gap-4 rounded-b-lg">
                        <a href="{{ route('shop.orders.show',$order) }}" class="btn btn-white">Batal</a>
                        <button type="submit" class="btn btn-primary">Kirim Bukti</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <script>
        const fileInput = document.getElementById('file-upload');
        const fileNamesDisplay = document.getElementById('file-name-display');
        fileInput.addEventListener('change', function() {
            if (this.files.length > 0) {
                fileNamesDisplay.textContent = this.files[0].name;
            } else {
                fileNamesDisplay.textContent = '';
            }
        });
    </script>
</x-app-layout>
