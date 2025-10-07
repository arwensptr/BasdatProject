<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ForgotPasswordController extends Controller
{
    public function showForgotForm()
    {
        return view('auth.forgot-password');
    }

    public function checkEmail(Request $request)
    {
        $request->validate(['email' => 'required|email']);

        $user = DB::table('users')->where('email', $request->email)->first();

        if (!$user) {
            return back()->with('error', 'Email tidak ditemukan dalam database.');
        }

        // Arahkan ke halaman reset password sambil bawa email-nya
        return redirect()->route('reset-password', ['email' => $request->email]);
    }
}
