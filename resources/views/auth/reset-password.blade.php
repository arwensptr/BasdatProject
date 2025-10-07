<x-guest-layout>
    <div class="max-w-md mx-auto mt-10 p-6 bg-white rounded shadow">
        <h2 class="text-2xl font-bold mb-4">Reset Password</h2>

        <form method="POST" action="{{ route('reset-password.post') }}">
            @csrf
            <input type="hidden" name="email" value="{{ $email }}">

            <div class="mb-4">
                <label class="block text-gray-700">Password Baru</label>
                <input type="password" name="password" class="w-full border p-2 rounded" required>
            </div>

            <div class="mb-4">
                <label class="block text-gray-700">Konfirmasi Password</label>
                <input type="password" name="password_confirmation" class="w-full border p-2 rounded" required>
            </div>

            <button type="submit" class="btn btn-primary w-full">Ubah Password</button>
        </form>
    </div>
</x-guest-layout>
