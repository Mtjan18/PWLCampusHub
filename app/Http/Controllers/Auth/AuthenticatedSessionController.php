<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\ValidationException;

class AuthenticatedSessionController extends Controller
{
    // Tampilkan form login (sudah kamu punya, tapi tetap harus ada method ini)
    public function create()
    {
        return view('auth.login'); // sesuaikan nama view login-mu
    }

    // Proses login
    public function store(Request $request)
    {
        // Validasi input
        $credentials = $request->validate([
            'email' => ['required', 'email'],
            'password' => ['required'],
        ]);

        $remember = $request->boolean('remember');


        if (Auth::attempt($credentials, $remember)) {
            $request->session()->regenerate();

            $user = Auth::user();
            if ($user->role->name === 'admin') {
                return redirect()->route('admin.dashboard');
            } elseif ($user->role->name === 'member') {
                return redirect()->route('member.dashboard');
            } elseif ($user->role->name === 'panitia') {
                return redirect()->route('member.dashboard');
            } elseif ($user->role->name === 'tim_keuangan') {
                return redirect()->route('member.dashboard');
            } else {
                return redirect()->intended('/');
            }
        }

        // Jika login gagal, lempar error validasi manual
        throw ValidationException::withMessages([
            'email' => __('auth.failed'),
        ]);
    }

    // Logout
    public function destroy(Request $request)
    {
        Auth::logout();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect('/');
    }
}
