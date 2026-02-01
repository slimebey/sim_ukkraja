<?php

namespace App\Http\Controllers;

use App\Models\InputAspirasi;
use App\Models\Siswa;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class SiswaController extends Controller
{
    public function dashboard()
    {
        $user = Auth::user();
        
       
        $siswa = Siswa::where('nisn', $user->username)->first();

        if (!$siswa) {
            Auth::logout();
            return redirect()->route('login')
                ->with('error', 'Data siswa tidak ditemukan. Hubungi admin.');
        }

      
        $stats = [
            'total' => InputAspirasi::where('id_siswas', $siswa->id)->count(),
            'menunggu' => InputAspirasi::where('id_siswas', $siswa->id)
                ->whereHas('aspirasi', fn($q) => $q->where('status', 'menunggu'))
                ->count(),
            'proses' => InputAspirasi::where('id_siswas', $siswa->id)
                ->whereHas('aspirasi', fn($q) => $q->where('status', 'proses'))
                ->count(),
            'selesai' => InputAspirasi::where('id_siswas', $siswa->id)
                ->whereHas('aspirasi', fn($q) => $q->where('status', 'selesai'))
                ->count(),
        ];

        $aspirasiTerbaru = InputAspirasi::with(['kategori', 'aspirasi'])
            ->where('id_siswas', $siswa->id)
            ->latest('tanggal_lapor')
            ->limit(3)
            ->get();

        return view('siswa.dashboard', compact('siswa', 'stats', 'aspirasiTerbaru'));
    }
}