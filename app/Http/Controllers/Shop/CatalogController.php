<?php

namespace App\Http\Controllers\Shop;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\Medicine;
use Illuminate\Http\Request;

class CatalogController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $q = $request->query('q');
        $categorySlug = $request->query('category');

        $activeCategory = null;
        if ($categorySlug) {
            $activeCategory = Category::where('slug', $categorySlug)->first();
        }

        $medicines = Medicine::query()
            ->when($q, fn($qq) => $qq->where('name', 'like', "%$q%"))
            ->when($activeCategory, function ($qq) use ($activeCategory) {
                // if a parent category is clicked, get all its children
                $ids = $activeCategory->children()->pluck('id')->toArray();
                if (empty($ids)) {
                    $ids = [$activeCategory->id];
                }
                $qq->whereIn('category_id', $ids);
            })
            ->orderBy('name')
            ->paginate(12)
            ->withQueryString();

        // Get the category tree (parent + children)
        $groups = Category::with('children')->whereNull('parent_id')->orderBy('name')->get();

        return view('shop.catalog', compact('medicines', 'q', 'groups', 'activeCategory', 'categorySlug'));
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Medicine  $medicine
     * @return \Illuminate\Http\Response
     */
    public function show(Medicine $medicine)
    {
        return view('shop.product_show', compact('medicine'));
    }
}
