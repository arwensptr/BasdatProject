<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\Medicine;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Storage; // <-- PERBAIKAN #1: Tambahkan ini

class MedicineController extends Controller
{
    public function index(Request $request)
    {
        // Ambil keyword pencarian dari URL
        $q = $request->query('q');

        $medicines = Medicine::query()
            // Jalankan blok ini HANYA JIKA ada keyword pencarian ($q)
            ->when($q, function($query, $q) {
                $query->where('name', 'like', "%{$q}%")
                    ->orWhereHas('category', function($catQuery) use ($q) {
                        $catQuery->where('name', 'like', "%{$q}%");
                    });
            })
            ->with('category')
            ->orderBy('name')
            ->paginate(12)
            ->withQueryString(); // Agar link paginasi tetap membawa keyword pencarian

        return view('admin.medicines.index', compact('medicines', 'q'));
    }

    public function create()
    {
        $categories = Category::orderBy('name')->get();
        return view('admin.medicines.create', compact('categories'));
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'name' => 'required|string|max:200',
            'category_id' => 'nullable|exists:categories,id',
            'price' => 'required|numeric|min:0',
            'stock' => 'required|integer|min:0',
            'description' => 'nullable|string|max:2000',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,webp',
        ]);

        $data['is_prescription_only'] = $request->has('is_prescription_only');

        if ($request->hasFile('image')) {
            $data['image'] = $request->file('image')->store('medicines', 'public');
        }

        $data['slug'] = $this->uniqueSlug($data['name']);

        Medicine::create($data);

        return redirect()->route('admin.medicines.index')->with('success', 'Obat berhasil dibuat.');
    }

    public function addStock(Request $request, Medicine $medicine)
    {
        $validated = $request->validate(['qty' => 'required|integer|min:1']);
        $medicine->increment('stock', $validated['qty']);

        return back()->with('success', "Stok '{$medicine->name}' bertambah {$validated['qty']}.");
    }

    public function edit(Medicine $medicine)
    {
        $categories = Category::orderBy('name')->get();
        return view('admin.medicines.edit', compact('medicine', 'categories'));
    }

    public function update(Request $request, Medicine $medicine)
    {
        $data = $request->validate([
            'name' => 'required|string|max:200',
            'category_id' => 'nullable|exists:categories,id',
            'price' => 'required|numeric|min:0',
            'stock' => 'required|integer|min:0',
            'description' => 'nullable|string|max:2000',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,webp',
        ]);

        $data['is_prescription_only'] = $request->has('is_prescription_only');

        if ($request->hasFile('image')) {
            if ($medicine->image) {
                Storage::disk('public')->delete($medicine->image);
            }
            $data['image'] = $request->file('image')->store('medicines', 'public');
        }

        // PERBAIKAN #2: Logika slug hanya dijalankan jika nama obat berubah
        if ($request->name !== $medicine->name) {
            $data['slug'] = $this->uniqueSlug($request->name);
        }

        $medicine->update($data);

        return redirect()->route('admin.medicines.index')->with('success', 'Obat berhasil diupdate.');
    }

    private function uniqueSlug(string $name): string
    {
        $slug = Str::slug($name);
        $base = $slug;
        $i = 2;
        while (Medicine::where('slug', $slug)->exists()) {
            $slug = "{$base}-{$i}";
            $i++;
        }
        return $slug;
    }
}