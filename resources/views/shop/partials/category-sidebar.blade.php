<aside class="card pad w-full md:w-72">
    <div class="font-semibold text-lg mb-3 dark:text-white">Kategori Obat</div>
    <div class="space-y-2">
        @foreach($groups as $g)
            <details {{ (isset($activeCategory) && ($activeCategory->id === $g->id || $activeCategory->parent_id === $g->id)) ? 'open' : '' }}>
                {{-- [FIX] Menambahkan class untuk dark mode pada trigger dropdown --}}
                <summary class="cursor-pointer px-2 py-2 rounded-lg hover:bg-brand-50 font-medium text-slate-700 dark:text-slate-300 dark:hover:bg-slate-700">
                    {{ $g->name }}
                </summary>

                <nav class="mt-1 ml-3 flex flex-col">
                    {{-- [FIX] Menambahkan class untuk dark mode pada link --}}
                    <a href="{{ route('shop.index', array_filter(['category'=>$g->slug,'q'=>request('q')])) }}"
                       class="py-1 text-sm {{ request('category')===$g->slug ? 'text-brand-700 font-semibold dark:text-brand-400' : 'text-gray-700 hover:text-brand-700 dark:text-slate-400 dark:hover:text-brand-400' }}">
                       Semua di {{ $g->name }}
                    </a>
                    @foreach($g->children as $child)
                        {{-- [FIX] Menambahkan class untuk dark mode pada link anak --}}
                        <a href="{{ route('shop.index', array_filter(['category'=>$child->slug,'q'=>request('q')])) }}"
                           class="py-1 text-sm {{ request('category')===$child->slug ? 'text-brand-700 font-semibold dark:text-brand-400' : 'text-gray-700 hover:text-brand-700 dark:text-slate-400 dark:hover:text-brand-400' }}">
                           {{ $child->name }}
                        </a>
                    @endforeach
                </nav>
            </details>
        @endforeach
    </div>
</aside>
