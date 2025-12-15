<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\Medicine;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Storage; // Digunakan untuk menghapus gambar lama

class MedicineController extends Controller
{
    /**
     * Menampilkan daftar obat, dengan fitur pencarian dan paginasi.
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\View\View
     */
    public function index(Request $request)
    {
        // Ambil keyword pencarian dari URL
        $q = $request->query('q');

        $medicines = Medicine::query()
            // Jalankan blok ini HANYA JIKA ada keyword pencarian ($q)
            ->when($q, function ($query, $q) {
                $query->where('name', 'like', "%{$q}%")
                    ->orWhereHas('category', function ($catQuery) use ($q) {
                        $catQuery->where('name', 'like', "%{$q}%");
                    });
            })
            ->with('category')
            ->orderBy('name')
            ->paginate(12)
            ->withQueryString(); // Agar link paginasi tetap membawa keyword pencarian

        return view('admin.medicines.index', compact('medicines', 'q'));
    }

    /**
     * Menampilkan form untuk membuat obat baru.
     *
     * @return \Illuminate\View\View
     */
    public function create()
    {
        $categories = Category::orderBy('name')->get();
        return view('admin.medicines.create', compact('categories'));
    }

    /**
     * Menyimpan data obat baru ke database.
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function store(Request $request)
    {
        $data = $request->validate([
            'name'              => 'required|string|max:200',
            'category_id'       => 'nullable|exists:categories,id',
            'price'             => 'required|numeric|min:0',
            'stock'             => 'required|integer|min:0',
            'description'       => 'nullable|string|max:2000',
            'image'             => 'nullable|image|mimes:jpeg,png,jpg,webp',
        ]);

        $data['is_prescription_only'] = $request->has('is_prescription_only');

        if ($request->hasFile('image')) {
            // Menyimpan gambar ke folder 'storage/app/public/medicines'
            $data['image'] = $request->file('image')->store('medicines', 'public');
        }

        // Membuat slug unik
        $data['slug'] = $this->uniqueSlug($data['name']);

        Medicine::create($data);

        return redirect()->route('admin.medicines.index')->with('success', 'Obat berhasil dibuat.');
    }

    /**
     * Menambahkan stok obat.
     *
     * @param \Illuminate\Http\Request $request
     * @param \App\Models\Medicine $medicine
     * @return \Illuminate\Http\RedirectResponse
     */
    public function addStock(Request $request, Medicine $medicine)
    {
        $validated = $request->validate([
            'qty' => 'required|integer|min:1'
        ]);

        // Menambahkan stok
        $medicine->increment('stock', $validated['qty']);

        return back()->with('success', "Stok '{$medicine->name}' bertambah {$validated['qty']}.");
    }

    /**
     * Menampilkan form untuk mengedit obat.
     *
     * @param \App\Models\Medicine $medicine
     * @return \Illuminate\View\View
     */
    public function edit(Medicine $medicine)
    {
        $categories = Category::orderBy('name')->get();
        return view('admin.medicines.edit', compact('medicine', 'categories'));
    }

    /**
     * Memperbarui data obat yang sudah ada.
     *
     * @param \Illuminate\Http\Request $request
     * @param \App\Models\Medicine $medicine
     * @return \Illuminate\Http\RedirectResponse
     */
    public function update(Request $request, Medicine $medicine)
    {
        $data = $request->validate([
            'name'              => 'required|string|max:200',
            'category_id'       => 'nullable|exists:categories,id',
            'price'             => 'required|numeric|min:0',
            'stock'             => 'required|integer|min:0',
            'description'       => 'nullable|string|max:2000',
            'image'             => 'nullable|image|mimes:jpeg,png,jpg,webp',
        ]);

        $data['is_prescription_only'] = $request->has('is_prescription_only');

        if ($request->hasFile('image')) {
            // Hapus gambar lama jika ada
            if ($medicine->image) {
                Storage::disk('public')->delete($medicine->image);
            }
            // Simpan gambar baru
            $data['image'] = $request->file('image')->store('medicines', 'public');
        }

        // Logika slug hanya dijalankan jika nama obat berubah
        if ($request->name !== $medicine->name) {
            $data['slug'] = $this->uniqueSlug($request->name);
        }

        $medicine->update($data);

        return redirect()->route('admin.medicines.index')->with('success', 'Obat berhasil diupdate.');
    }

    /**
     * Membuat slug unik berdasarkan nama.
     *
     * @param string $name
     * @return string
     */
    private function uniqueSlug(string $name): string
    {
        $slug = Str::slug($name);
        $base = $slug;
        $i = 2;

        // Cek apakah slug sudah ada, jika ya, tambahkan angka di belakangnya
        while (Medicine::where('slug', $slug)->exists()) {
            $slug = "{$base}-{$i}";
            $i++;
        }

        return $slug;
    }
}