<x-app-layout>
  <x-slot name="header"><h2 class="font-display text-2xl text-brand-800">Manajemen Order</h2></x-slot>

  <div class="admin-grid section">
    @include('admin.partials.sidebar')

    <div class="section">
      @if(session('success'))<div class="card pad text-emerald-700">{{ session('success') }}</div>@endif

      <div class="table-wrap">
        <table class="min-w-full text-sm table-ui">
          <thead>
            <tr>
              <th>Order</th><th>Customer</th><th>Status</th>
              <th class="text-right">Total</th><th>Pengiriman</th><th>Aksi</th>
            </tr>
          </thead>
          <tbody class="divide-y">
            @foreach($orders as $o)
              <tr class="hover:bg-brand-50/30">
                <td>#{{ $o->id }}</td>
                <td>{{ $o->user->name }}</td>
                <td><x-status-badge :status="$o->status"/></td>
                <td class="text-right">Rp {{ number_format($o->total_amount,0,',','.') }}</td>
                <td>
                  @if($o->shipment)
                    <div class="text-xs">{{ $o->shipment->courier_name }} / {{ $o->shipment->tracking_number }}</div>
                  @else
                    <span class="text-xs text-gray-500">-</span>
                  @endif
                </td>
                <td>
                  <form method="POST" action="{{ route('admin.orders.updateStatus',$o) }}">
                      @csrf
                      <div class="flex items-center gap-2 mb-2">
                          {{-- 👇 PERUBAHAN DI SINI --}}
                          <select 
                              name="action" 
                              class="flex-grow rounded-lg border-gray-300 pl-4 pr-10 py-3 text-left text-sm
                                    appearance-none
                                    bg-no-repeat bg-right-3 bg-center
                                    bg-[url('data:image/svg+xml;utf8,<svg xmlns=\'http://www.w3.org/2000/svg\' class=\'h-5 w-5\' viewBox=\'0 0 20 20\' fill=\'currentColor\'><path fill-rule=\'evenodd\' d=\'M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z\' clip-rule=\'evenodd\' /></svg>')]
                                    focus:ring-brand-500 focus:border-brand-500"
                          >
                              <option value="processing">Processing</option>
                              <option value="ship">Shipped</option>
                              <option value="deliver">Delivered</option>
                              <option value="cancel">Cancel</option>
                          </select>
                          <button class="btn btn-primary px-4 py-2 flex-shrink-0">Apply</button>
                      </div>
                      <div class="flex items-center gap-2">
                          <input name="courier_name" placeholder="Kurir" class="w-1/2 border rounded-lg border-gray-300 px-3 py-2 text-xs focus:ring-brand-500 focus:border-brand-500" value="{{ $o->shipment->courier_name ?? '' }}">
                          <input name="tracking_number" placeholder="No. Resi" class="w-1/2 border rounded-lg border-gray-300 px-3 py-2 text-xs focus:ring-brand-500 focus:border-brand-500" value="{{ $o->shipment->tracking_number ?? '' }}">
                      </div>
                  </form>
                </td>
              </tr>
            @endforeach
          </tbody>
        </table>
      </div>

      <div>{{ $orders->links() }}</div>
    </div>
  </div>
</x-app-layout>