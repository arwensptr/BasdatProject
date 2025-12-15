<aside class="card pad w-full md:w-[280px] h-fit sticky top-28">
   <div class="flex items-center gap-3 mb-4">
      <div class="w-10 h-10 rounded-full bg-brand-600 text-white flex items-center justify-center font-semibold">{{ strtoupper(substr(auth()->user()->name,0,1)) }}</div>
      <div>
         <div class="text-sm font-semibold dark:text-white">{{ auth()->user()->name }}</div>
         <div class="text-xs text-gray-400">Administrator</div>
      </div>
   </div>

   <nav class="flex flex-col gap-1 rounded-xl">
      <a href="{{ route('admin.dashboard') }}"
         class="px-4 py-2 rounded-xl flex items-center gap-3 {{ request()->routeIs('admin.dashboard') ? 'bg-brand-50 text-brand-700 dark:bg-brand-500/20 dark:text-brand-300' : 'hover:bg-brand-50 dark:text-slate-300 dark:hover:bg-slate-700' }}">
         <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" viewBox="0 0 24 24" fill="none" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M3 12l2-2m0 0l7-7 7 7M13 5v6h6"></path></svg>
         <span>Dashboard</span>
      </a>

      <a href="{{ route('admin.prescriptions.index') }}"
         class="px-4 py-2 rounded-xl flex items-center gap-3 {{ request()->routeIs('admin.prescriptions.*') ? 'bg-brand-50 text-brand-700 dark:bg-brand-500/20 dark:text-brand-300' : 'hover:bg-brand-50 dark:text-slate-300 dark:hover:bg-slate-700' }}">
         <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" viewBox="0 0 24 24" fill="none" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M12 8v4l3 3"></path></svg>
         <span>Resep</span>
      </a>

      <a href="{{ route('admin.payments.index') }}"
         class="px-4 py-2 rounded-xl flex items-center gap-3 {{ request()->routeIs('admin.payments.*') ? 'bg-brand-50 text-brand-700 dark:bg-brand-500/20 dark:text-brand-300' : 'hover:bg-brand-50 dark:text-slate-300 dark:hover:bg-slate-700' }}">
         <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" viewBox="0 0 24 24" fill="none" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M12 8c-2.21 0-4 .895-4 2v4c0 1.105 1.79 2 4 2s4-.895 4-2v-4c0-1.105-1.79-2-4-2z"></path></svg>
         <span>Review Pembayaran</span>
      </a>

      <a href="{{ route('admin.orders.index') }}"
         class="px-4 py-2 rounded-xl flex items-center gap-3 {{ request()->routeIs('admin.orders.*') ? 'bg-brand-50 text-brand-700 dark:bg-brand-500/20 dark:text-brand-300' : 'hover:bg-brand-50 dark:text-slate-300 dark:hover:bg-slate-700' }}">
         <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" viewBox="0 0 24 24" fill="none" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M3 7h18M7 7v10a2 2 0 002 2h6a2 2 0 002-2V7"></path></svg>
         <span>Manajemen Order</span>
      </a>

      <a href="{{ route('admin.medicines.index') }}"
         class="px-4 py-2 rounded-xl flex items-center gap-3 {{ request()->routeIs('admin.medicines.*') ? 'bg-brand-50 text-brand-700 dark:bg-brand-500/20 dark:text-brand-300' : 'hover:bg-brand-50 dark:text-slate-300 dark:hover:bg-slate-700' }}">
         <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" viewBox="0 0 24 24" fill="none" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M12 2l3 7h7l-5.5 4 2 7L12 17l-6.5 3 2-7L2 9h7z"></path></svg>
         <span>Stok Obat</span>
      </a>
   </nav>
</aside>
