<x-app-layout>
    <x-slot name="header">
        <h2 class="text-2xl font-semibold dark:text-slate-200">Tambah Obat</h2>
    </x-slot>

    <div class="admin-grid section">
        @include('admin.partials.sidebar')

        <div class="section">
            <div class="card pad">
                <form method="POST" action="{{ route('admin.medicines.store') }}" class="space-y-5" enctype="multipart/form-data">
                    @csrf

                    <div>
                        <label class="block text-sm font-medium dark:text-slate-300">Nama Obat</label>
                        <input name="name" type="text" value="{{ old('name') }}" required
                               class="mt-1 w-full rounded-xl border-gray-300 focus:border-brand-400 focus:ring-brand-300 dark:bg-slate-900 dark:border-slate-700">
                        <x-input-error :messages="$errors->get('name')" class="mt-2" />
                    </div>

                    <div class="grid sm:grid-cols-2 gap-4">
                        <div>
                            <label class="block text-sm font-medium dark:text-slate-300">Kategori</label>
                            <select name="category_id" class="mt-1 w-full rounded-xl border-gray-300 focus:border-brand-400 focus:ring-brand-300 dark:bg-slate-900 dark:border-slate-700">
                                <option value="">— Tanpa kategori —</option>
                                @foreach($categories as $c)
                                    <option value="{{ $c->id }}" @selected(old('category_id')==$c->id)>{{ $c->name }}</option>
                                @endforeach
                            </select>
                        </div>

                        <div>
                            <label class="block text-sm font-medium dark:text-slate-300">Harga</label>
                            <input name="price" type="number" step="0.01" min="0" value="{{ old('price','0') }}" required
                                   class="mt-1 w-full rounded-xl border-gray-300 focus:border-brand-400 focus:ring-brand-300 dark:bg-slate-900 dark:border-slate-700">
                            <x-input-error :messages="$errors->get('price')" class="mt-2" />
                        </div>
                    </div>

                    <div class="grid sm:grid-cols-2 gap-4">
                        <label class="inline-flex items-center gap-2">
                            <input type="checkbox" name="is_prescription_only" value="1"
                                   class="rounded border-gray-300 text-brand-600 focus:ring-brand-400 dark:bg-slate-900 dark:border-slate-700"
                                   @checked(old('is_prescription_only'))>
                            <span class="dark:text-slate-300">Perlu Resep</span>
                        </label>

                        <div>
                            <label class="block text-sm font-medium dark:text-slate-300">Stok Awal</label>
                            <input name="stock" type="number" min="0" value="{{ old('stock',0) }}" required
                                   class="mt-1 w-full rounded-xl border-gray-300 focus:border-brand-400 focus:ring-brand-300 dark:bg-slate-900 dark:border-slate-700">
                            <x-input-error :messages="$errors->get('stock')" class="mt-2" />
                        </div>
                    </div>

                    <div>
                        <label class="block text-sm font-medium dark:text-slate-300">Deskripsi (opsional)</label>
                        <textarea name="description" rows="4"
                            class="mt-1 w-full rounded-xl border-gray-300 focus:border-brand-400 focus:ring-brand-300 dark:bg-slate-900 dark:border-slate-700">{{ old('description') }}</textarea>
                    </div>
                    
                    <div>
                        <label for="image" class="block text-sm font-medium dark:text-slate-300">Gambar Obat</label>
                        <input type="file" name="image" id="image" class="block w-full mt-1 dark:text-slate-300">
                    </div>

                    <div class="flex items-center justify-end gap-2 pt-4">
                        <a href="{{ route('admin.medicines.index') }}" class="btn btn-white">Batal</a>
                        <button class="btn btn-primary">Simpan</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</x-app-layout>
