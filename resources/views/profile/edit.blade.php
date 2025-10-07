<x-app-layout>
  <x-slot name="header">
    <h2 class="text-2xl font-semibold text-gray-800">Edit Profile</h2>
  </x-slot>

  <div class="py-8">
    <div class="max-w-4xl mx-auto sm:px-6 lg:px-8 space-y-6">

      {{-- PESAN SUKSES --}}
      @if(session('status') === 'profile-updated')
        <div class="p-4 bg-green-50 border-l-4 border-green-400 text-green-800 rounded-r-lg">
          <p class="font-bold">Sukses!</p>
          <p class="text-sm">Informasi profil Anda telah berhasil diperbarui.</p>
        </div>
      @endif

      {{-- KARTU UPDATE PROFILE --}}
      <div class="bg-white shadow-lg rounded-lg">
        <form method="POST" action="{{ route('profile.update') }}">
          @csrf
          @method('PATCH')
          
          <div class="p-6">
            <h3 class="text-xl font-semibold mb-4">Informasi Profil</h3>
            <div class="space-y-4">
              {{-- Input Nama --}}
              <div>
                <label for="name" class="block text-sm font-medium text-gray-700 mb-1">Nama</label>
                <div class="flex items-center gap-3 rounded-lg border border-gray-50 bg-gray-50 px-4 py-3 shadow-sm focus-within:border-cyan-500 focus-within:ring-1 focus-within:ring-cyan-500">
                  <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-gray-400" viewBox="0 0 20 20" fill="currentColor"><path fill-rule="evenodd" d="M10 9a3 3 0 100-6 3 3 0 000 6zm-7 9a7 7 0 1114 0H3z" clip-rule="evenodd" /></svg>
                  <input type="text" id="name" name="name" class="w-full bg-transparent p-0 text-sm" style="border: none !important; box-shadow: none !important; outline: none !important;" required value="{{ old('name', $user->name) }}">
                </div>
                @error('name')<div class="text-red-600 text-sm mt-1">{{ $message }}</div>@enderror
              </div>

              {{-- Input Email --}}
              <div>
                <label for="email" class="block text-sm font-medium text-gray-700 mb-1">Email</label>
                <div class="flex items-center gap-3 rounded-lg border border-gray-50 bg-gray-50 px-4 py-3 shadow-sm focus-within:border-cyan-500 focus-within:ring-1 focus-within:ring-cyan-500">
                  <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-gray-400" viewBox="0 0 20 20" fill="currentColor"><path d="M2.003 5.884L10 9.882l7.997-3.998A2 2 0 0016 4H4a2 2 0 00-1.997 1.884z" /><path d="M18 8.118l-8 4-8-4V14a2 2 0 002 2h12a2 2 0 002-2V8.118z" /></svg>
                  <input type="email" id="email" name="email" class="w-full bg-transparent p-0 text-sm" style="border: none !important; box-shadow: none !important; outline: none !important;" required value="{{ old('email', $user->email) }}">
                </div>
                @error('email')<div class="text-red-600 text-sm mt-1">{{ $message }}</div>@enderror
              </div>
            </div>
          </div>

          {{-- Tombol Aksi Update --}}
          <div class="bg-gray-50 px-6 py-4 flex justify-end rounded-b-lg">
            <button class="px-6 py-2 bg-cyan-500 text-white font-bold rounded-lg shadow-md hover:bg-cyan-600 transition-colors">
              Simpan
            </button>
          </div>
        </form>
      </div>

      {{-- KARTU HAPUS AKUN --}}
      <div class="bg-white shadow-lg rounded-lg">
        <form method="POST" action="{{ route('profile.destroy') }}">
          @csrf
          @method('DELETE')

          <div class="p-6">
            <h3 class="text-xl font-semibold text-red-700">Hapus Akun</h3>
            <div class="mt-4 p-4 bg-red-50 border-l-4 border-red-400 text-red-800 rounded-r-lg">
              <p class="font-bold">Peringatan!</p>
              <p class="text-sm">Setelah akun Anda dihapus, semua data akan hilang secara permanen. Harap masukkan kata sandi Anda untuk mengonfirmasi.</p>
            </div>
            <div class="mt-4">
              <label for="password" class="block text-sm font-medium text-gray-700 mb-1">Konfirmasi Kata Sandi</label>
              <div class="flex items-center gap-3 rounded-lg border border-gray-200 bg-gray-50 px-4 py-3 shadow-sm focus-within:border-red-500 focus-within:ring-1 focus-within:ring-red-500">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-gray-400" viewBox="0 0 20 20" fill="currentColor"><path fill-rule="evenodd" d="M5 9V7a5 5 0 0110 0v2a2 2 0 012 2v5a2 2 0 01-2 2H5a2 2 0 01-2-2v-5a2 2 0 012-2zm8-2v2H7V7a3 3 0 016 0z" clip-rule="evenodd" /></svg>
                <input type="password" id="password" name="password" class="w-full border-0 bg-transparent p-0 text-sm focus:ring-0" required placeholder="Masukkan kata sandi Anda">
              </div>
              @error('password', 'userDeletion')<div class="text-red-600 text-sm mt-1">{{ $message }}</div>@enderror
            </div>
          </div>

          {{-- Tombol Aksi Hapus --}}
          <div class="bg-gray-50 px-6 py-6 flex justify-end rounded-b-lg">
            <button class="px-6 py-2 bg-red-600 text-white font-bold rounded-lg shadow-md hover:bg-red-700 transition-colors">
              Hapus Akun
            </button>
          </div>
        </form>
      </div>
    </div>
  </div>
</x-app-layout>