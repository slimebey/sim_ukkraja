<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class LoginController extends Controller
{
    public function showLoginForm()
    {
        if (Auth::check()) {
            return $this->redirectToDashboard();
        }
        return view('auth.login'); 
    }
    public function login(Request $request)
    {
        $credentials = $request->validate([
            'username' => 'required|string',
            'password' => 'required|string',
            'login_as' => 'required|in:admin,siswa', 
        ], [
            'username.required' => 'Username/NISN wajib diisi',
            'password.required' => 'Password wajib diisi',
            'login_as.required' => 'Silakan pilih login sebagai apa',
        ]);

        if ($credentials['login_as'] === 'admin') {
            if ($credentials['username'] !== 'admin') {
                return back()->withErrors([
                    'login_as' => 'Anda tidak memiliki akses sebagai Admin.',
                ])->onlyInput('username', 'login_as');
            }
        } else {
            if ($credentials['username'] === 'admin') {
                return back()->withErrors([
                    'login_as' => 'Akun admin tidak dapat login sebagai Siswa.',
                ])->onlyInput('username', 'login_as');
            }
        }

        // Attempt login
        if (Auth::attempt([
            'username' => $credentials['username'],
            'password' => $credentials['password'],
        ], $request->filled('remember'))) {
            
            $request->session()->regenerate();
            return $this->redirectToDashboard();
        }

        return back()->withErrors([
            'username' => 'Username/NISN atau password salah.',
        ])->onlyInput('username', 'login_as');
    }

    public function logout(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect()->route('login')
            ->with('success', 'Berhasil logout!');
    }

    private function redirectToDashboard()
    {
        $user = Auth::user();

        if ($user->isAdmin()) {
            return redirect()->route('admin.dashboard')
                ->with('success', 'Selamat datang, Admin!');
        }

        return redirect()->route('siswa.dashboard')
            ->with('success', 'Selamat datang, ' . $user->username . '!');
    }
}