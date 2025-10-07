<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use App\Models\User;

class ResetPasswordController extends Controller
{
    // Halaman lupa password
    public function showForgotForm()
    {
        return view('auth.forgot-password');
    }

    // Cek email dan langsung redirect ke form reset password
    public function checkEmailAndRedirect(Request $request)
    {
        $request->validate(['email' => 'required|email']);

        $user = User::where('email', $request->email)->first();

        if (!$user) {
            return back()->withErrors(['email' => 'Email tidak ditemukan']);
        }

        // Langsung arahkan ke halaman reset password tanpa token
        return redirect()->route('reset-password', ['email' => $user->email]);
    }

    // Tampilkan form reset password
    public function showResetForm($email)
    {
        return view('auth.reset-password', compact('email'));
    }

    // Update password di database
    public function resetPassword(Request $request)
    {
        $request->validate([
            'email' => 'required|email|exists:users,email',
            'password' => 'required|confirmed|min:6',
        ]);

        User::where('email', $request->email)->update([
            'password' => Hash::make($request->password),
        ]);

        return redirect()->route('login')->with('status', 'Password berhasil direset.');
    }
}
