<x-app-layout>
  <x-slot name="header">
    <div class="flex items-center justify-between">
      <h2 class="text-2xl font-semibold text-gray-800">Detail Pesanan #{{ $order->id }}</h2>
      <div class="flex items-center gap-2">
        <a href="{{ route('shop.orders.index') }}" class="btn btn-white">← Semua Pesanan</a>
      </div>
    </div>
  </x-slot>

  <div class="py-8">
    <div class="max-w-4xl mx-auto sm:px-6 lg:px-8 space-y-6">
      {{-- Session Messages --}}
      @if (session('success'))
        <div class="p-4 bg-green-50 border-l-4 border-green-400 text-green-800 rounded-r-lg">
          <p>{{ session('success') }}</p>
        </div>
      @endif
      @if (session('error'))
        <div class="p-4 bg-red-50 border-l-4 border-red-400 text-red-800 rounded-r-lg">
          <p>{{ session('error') }}</p>
        </div>
      @endif

      {{-- KARTU AKSI UTAMA --}}
      <div class="bg-white shadow-lg rounded-lg p-6">
        <h3 class="text-lg font-semibold text-gray-800 mb-2">Status & Aksi</h3>
        <div class="text-center sm:text-left sm:flex sm:items-center sm:justify-between p-4 bg-gray-50 rounded-lg">
          <div>
            <p class="font-bold text-cyan-600 capitalize text-xl mb-1">{{ str_replace('_', ' ', $order->status) }}</p>
            <p class="text-gray-600 text-sm">
              @switch($order->status)
                @case('awaiting_prescription_upload') Order ini membutuhkan resep. Silakan upload resep untuk melanjutkan. @break
                @case('prescription_rejected') Resep ditolak. Silakan upload ulang resep. @break
                @case('prescription_under_review') Resep sedang ditinjau admin. Mohon tunggu. @break
                @case('awaiting_payment') Silakan lakukan pembayaran dalam 24 jam, lalu upload bukti. @break
                @case('payment_rejected') Bukti pembayaran ditolak. Silakan upload ulang. @break
                @case('payment_under_review') Bukti pembayaran sedang ditinjau admin. Mohon tunggu. @break
                @case('paid') Pembayaran diterima. Pesanan akan segera diproses. @break
                @case('processing') Pesanan sedang disiapkan. @break
                @case('shipped') Pesanan telah dikirim. @break
                @case('delivered') Pesanan selesai. Terima kasih! @break
                @case('cancelled') Pesanan telah dibatalkan. @break
                @default Status: {{ $order->status }}
              @endswitch
            </p>
          </div>
          <div class="mt-4 sm:mt-0 sm:ml-4 flex-shrink-0">
            @php $actionRoute = null; $actionText = ''; @endphp
            @switch($order->status)
                @case('awaiting_prescription_upload') @php $actionRoute = route('shop.prescriptions.create', $order); $actionText = 'Upload Resep'; @endphp @break
                @case('prescription_rejected') @php $actionRoute = route('shop.prescriptions.create', $order); $actionText = 'Upload Ulang Resep'; @endphp @break
                @case('awaiting_payment') @php $actionRoute = route('shop.payments.create', $order); $actionText = 'Upload Bukti Bayar'; @endphp @break
                @case('payment_rejected') @php $actionRoute = route('shop.payments.create', $order); $actionText = 'Upload Ulang Bukti'; @endphp @break
            @endswitch
            @if ($actionRoute)
              <a href="{{ $actionRoute }}" class="btn btn-white">
                {{ $actionText }}
              </a>
            @endif
          </div>
        </div>
      </div>

      {{-- Kartu Detail Pengiriman & Total --}}
      <div class="bg-white shadow-lg rounded-lg p-6">
        <h3 class="text-xl font-semibold mb-4 border-b pb-3">Ringkasan Pesanan</h3>
        <dl class="grid grid-cols-1 sm:grid-cols-2 gap-x-6 gap-y-4 text-sm">
          <div class="sm:col-span-2">
            <dt class="font-medium text-gray-500">Penerima</dt>
            <dd class="mt-1 text-gray-900">{{ $order->recipient_name }} ({{ $order->recipient_phone }})</dd>
          </div>
          <div class="sm:col-span-2">
            <dt class="font-medium text-gray-500">Alamat Pengiriman</dt>
            <dd class="mt-1 text-gray-900">{{ $order->shipping_address }}</dd>
          </div>
          <div>
            <dt class="font-medium text-gray-500">Tanggal Pesan</dt>
            <dd class="mt-1 text-gray-900">{{ $order->created_at->format('d M Y H:i') }}</dd>
          </div>
          <div>
            <dt class="font-medium text-gray-500">Total Pembayaran</dt>
            <dd class="mt-1 font-bold text-gray-900 text-base">Rp {{ number_format($order->total_amount, 0, ',', '.') }}</dd>
          </div>
        </dl>
      </div>

      {{-- Kartu Daftar Item --}}
      <div class="bg-white shadow-lg rounded-lg overflow-hidden">
        <h3 class="text-xl font-semibold px-6 pt-6 pb-4">Item yang Dipesan</h3>
        <table class="min-w-full w-full divide-y divide-gray-200">
          <thead class="bg-gray-50">
            <tr>
              <th scope="col" class="px-6 py-4 text-left text-xs font-medium text-gray-500 uppercase">Obat</th>
              <th scope="col" class="px-6 py-4 text-center text-xs font-medium text-gray-500 uppercase">Qty</th>
              <th scope="col" class="px-6 py-4 text-right text-xs font-medium text-gray-500 uppercase">Harga Satuan</th>
              <th scope="col" class="px-6 py-4 text-right text-xs font-medium text-gray-500 uppercase">Subtotal</th>
            </tr>
          </thead>
          <tbody class="bg-white divide-y divide-gray-200">
            @foreach($order->items as $it)
              <tr>
                <td class="px-6 py-6 whitespace-nowrap text-sm font-medium text-gray-900">{{ $it->medicine->name ?? 'Unknown' }}</td>
                <td class="px-6 py-6 whitespace-nowrap text-sm text-gray-500 text-center">{{ $it->qty }}</td>
                <td class="px-6 py-6 whitespace-nowrap text-sm text-gray-500 text-right">Rp {{ number_format($it->unit_price, 0, ',', '.') }}</td>
                <td class="px-6 py-6 whitespace-nowrap text-sm text-gray-800 font-semibold text-right">Rp {{ number_format($it->subtotal, 0, ',', '.') }}</td>
              </tr>
            @endforeach
          </tbody>
        </table>
      </div>
    </div>
  </div>
</x-app-layout>