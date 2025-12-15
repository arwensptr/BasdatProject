{{-- resources/views/shop/orders/index.blade.php --}}
<x-app-layout>
  <x-slot name="header">
    <div class="flex items-center justify-between">
      <h2 class="text-2xl font-semibold">Pesanan Saya</h2>
      <a href="{{ route('shop.index') }}" class="btn btn-white px-3 py-1">← Katalog</a>
    </div>
  </x-slot>

  <div class="section">
    {{-- Filter --}}
    <div class="card pad">
      <form method="GET" class="flex flex-wrap items-center gap-2">
        @php($status = request('status'))
        <label class="text-sm text-gray-600">Filter:</label>

        <select name="status" class="rounded-lg border-gray-300 focus:border-brand-400 focus:ring-brand-300">
          <option value="" {{ $status==='' || $status===null ? 'selected' : '' }}>Semua</option>
          <option value="open"    {{ $status==='open'    ? 'selected' : '' }}>Masih Berjalan</option>
          <option value="closed"  {{ $status==='closed'  ? 'selected' : '' }}>Selesai/Dibatalkan</option>

          @foreach([
            'awaiting_prescription_upload',
            'prescription_under_review',
            'prescription_rejected',
            'awaiting_payment',
            'payment_under_review',
            'payment_rejected',
            'paid',
            'processing',
            'shipped',
            'delivered',
            'cancelled'
          ] as $s)
            <option value="{{ $s }}" {{ $status===$s ? 'selected' : '' }}>{{ $s }}</option>
          @endforeach
        </select>

        <button class="btn btn-primary">Terapkan</button>

        @if ($status)
          <a href="{{ route('shop.orders.index') }}" class="text-sm text-brand-700 underline">Reset</a>
        @endif
      </form>
    </div>

    {{-- Tabel pesanan --}}
    <div class="table-wrap">
      <table class="min-w-full text-sm table-ui">
        <thead>
          <tr>
            <th>Order</th>
            <th>Tanggal</th>
            <th>Status</th>
            <th class="text-right">Total</th>
            <th>Aksi</th>
          </tr>
        </thead>

        <tbody class="divide-y">
          @forelse($orders as $o)
            <tr class="hover:bg-brand-50/30">
              <td>#{{ $o->id }}</td>
              <td>{{ $o->created_at->format('d M Y H:i') }}</td>
              <td>{{ $o->status }}</td>
              <td class="text-left">Rp {{ number_format($o->total_amount,0,',','.') }}</td>
              <td>
                <a class="btn btn-white px-3 py-1" href="{{ route('shop.orders.show', $o) }}">Detail</a>
              </td>
            </tr>
            {{-- rejection flash row(s) for this order (non-blocking) --}}
            @if(optional($o->prescription)->status === 'rejected' && optional($o->prescription)->note)
              <tr>
                <td colspan="5" class="px-6 py-3">
                  <div id="order-reject-{{ $o->id }}" class="order-reject hidden p-3 bg-red-50 border-l-4 border-red-400 text-red-800 rounded-r-lg dark:bg-red-900/30 dark:border-red-600 dark:text-red-300 transition-all duration-300 transform -translate-y-2 opacity-0">
                    <div class="flex items-start justify-between w-full">
                      <div class="flex-1">
                        <p class="font-semibold">Resep ditolak untuk order #{{ $o->id }}</p>
                        <p class="text-sm mt-1">{{ $o->prescription->note }}</p>
                      </div>
                      <button type="button" data-target="#order-reject-{{ $o->id }}" class="order-reject-close ml-4 text-red-700 hover:text-red-900">&times;</button>
                    </div>
                  </div>
                </td>
              </tr>
            @elseif($o->paymentProofs->where('status','rejected')->isNotEmpty())
              @php($rp = $o->paymentProofs->where('status','rejected')->sortByDesc('id')->first())
              @if($rp && $rp->reviewer_note)
                <tr>
                  <td colspan="5" class="px-6 py-3">
                    <div id="order-reject-{{ $o->id }}" class="order-reject hidden p-3 bg-red-50 border-l-4 border-red-400 text-red-800 rounded-r-lg dark:bg-red-900/30 dark:border-red-600 dark:text-red-300 transition-all duration-300 transform -translate-y-2 opacity-0">
                      <div class="flex items-start justify-between w-full">
                        <div class="flex-1">
                          <p class="font-semibold">Pembayaran ditolak untuk order #{{ $o->id }}</p>
                          <p class="text-sm mt-1">{{ $rp->reviewer_note }}</p>
                        </div>
                        <button type="button" data-target="#order-reject-{{ $o->id }}" class="order-reject-close ml-4 text-red-700 hover:text-red-900">&times;</button>
                      </div>
                    </div>
                  </td>
                </tr>
              @endif
            @endif
          @empty
            <tr>
              <td colspan="5" class="py-6 text-center text-gray-500">Tidak ada pesanan.</td>
            </tr>
          @endforelse
        </tbody>
      </table>
    </div>

    <div>{{ $orders->links() }}</div>
  </div>
</div>

@push('scripts')
<script>
  document.addEventListener('DOMContentLoaded', function(){
    // reveal rejection flashes then auto-hide after a delay
    document.querySelectorAll('.order-reject').forEach(function(el){
      if (!el) return;
      el.classList.remove('hidden');
      void el.offsetWidth; // force reflow
      el.classList.remove('-translate-y-2','opacity-0');
      clearTimeout(el._hideTimeout);
      el._hideTimeout = setTimeout(()=>{
        el.classList.add('-translate-y-2','opacity-0');
        setTimeout(()=> el.classList.add('hidden'), 300);
      }, 6000);
    });

    document.querySelectorAll('.order-reject-close').forEach(function(btn){
      btn.addEventListener('click', function(){
        const selector = this.getAttribute('data-target');
        const target = document.querySelector(selector);
        if (!target) return;
        clearTimeout(target._hideTimeout);
        target.classList.add('-translate-y-2','opacity-0');
        setTimeout(()=> target.classList.add('hidden'), 300);
      });
    });
  });
</script>
</div>
@endpush
</x-app-layout>
