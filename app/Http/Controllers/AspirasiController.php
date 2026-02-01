<?php

namespace App\Http\Controllers;

use App\Models\InputAspirasi;
use App\Models\Aspirasi;
use App\Models\Kategori;
use App\Models\Siswa;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class AspirasiController extends Controller
{
    public function create()
    {
        $user = Auth::user();
        $siswa = Siswa::where('nisn', $user->username)->first();
        
        if (!$siswa) {
            return redirect()->route('siswa.dashboard')
                ->with('error', 'Data siswa tidak ditemukan.');
        }
        
        $kategoris = Kategori::all();
        
        return view('siswa.buat', compact('siswa', 'kategoris'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'kategoris_id' => 'required|exists:kategoris,id',
            'lokasi' => 'required|string|max:50|min:3',
            'ket' => 'required|string|min:10',
        ], [
            'kategoris_id.required' => 'Kategori wajib dipilih',
            'lokasi.required' => 'Lokasi wajib diisi',
            'lokasi.min' => 'Lokasi minimal 3 karakter',
            'ket.required' => 'Keluhan wajib diisi',
            'ket.min' => 'Keluhan minimal 10 karakter',
        ]);

        $user = Auth::user();
        $siswa = Siswa::where('nisn', $user->username)->first();

        if (!$siswa) {
            return redirect()->route('siswa.dashboard')
                ->with('error', 'Data siswa tidak ditemukan.');
        }

        DB::beginTransaction();
        try {
            $aspirasi = Aspirasi::create([
                'status' => 'menunggu',
                'feedback' => null,
                'tanggal_feedback' => null,
            ]);

            InputAspirasi::create([
                'id_pelaporan' => $aspirasi->id_pelaporan,
                'kategoris_id' => $validated['kategoris_id'],
                'id_siswas' => $siswa->id,
                'lokasi' => $validated['lokasi'],
                'ket' => $validated['ket'],
                'tanggal_lapor' => now(),
            ]);

            DB::commit();

            return redirect()->route('siswa.histori')
                ->with('success', 'Aspirasi berhasil diajukan! Mohon tunggu untuk feedback dari admin.');

        } catch (\Exception $e) {
            DB::rollBack();
            
            return back()
                ->withInput()
                ->with('error', 'Gagal menyimpan aspirasi: ' . $e->getMessage());
        }
    }

    public function histori()
    {
        $user = Auth::user();
        $siswa = Siswa::where('nisn', $user->username)->first();

        if (!$siswa) {
            return redirect()->route('siswa.dashboard')
                ->with('error', 'Data siswa tidak ditemukan.');
        }

        $aspirasis = InputAspirasi::with(['kategori', 'aspirasi'])
            ->where('id_siswas', $siswa->id)
            ->latest('tanggal_lapor')
            ->paginate(10);

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

        return view('siswa.histori', compact('siswa', 'aspirasis', 'stats'));
    }

    public function show($id)
    {
        $user = Auth::user();
        $siswa = Siswa::where('nisn', $user->username)->first();

        if (!$siswa) {
            return redirect()->route('siswa.dashboard')
                ->with('error', 'Data siswa tidak ditemukan.');
        }

        $inputAspirasi = InputAspirasi::with(['kategori', 'aspirasi', 'siswa'])
            ->where('id', $id)
            ->where('id_siswas', $siswa->id)
            ->firstOrFail();

        return view('siswa.detail', compact('siswa', 'inputAspirasi'));
    }

    public function edit($id)
    {
        $user = Auth::user();
        $siswa = Siswa::where('nisn', $user->username)->first();

        if (!$siswa) {
            return redirect()->route('siswa.dashboard')
                ->with('error', 'Data siswa tidak ditemukan.');
        }

        $inputAspirasi = InputAspirasi::with(['aspirasi'])
            ->where('id', $id)
            ->where('id_siswas', $siswa->id)
            ->firstOrFail();

        
        if ($inputAspirasi->aspirasi->status !== 'menunggu') {
            return redirect()->route('siswa.histori')
                ->with('error', 'Aspirasi yang sudah diproses tidak dapat diedit!');
        }

        $kategoris = Kategori::all();

        return view('siswa.edit', compact('siswa', 'inputAspirasi', 'kategoris'));
    }

    public function update(Request $request, $id)
    {
        $validated = $request->validate([
            'kategoris_id' => 'required|exists:kategoris,id',
            'lokasi' => 'required|string|max:50|min:3',
            'ket' => 'required|string|min:10',
        ], [
            'kategoris_id.required' => 'Kategori wajib dipilih',
            'lokasi.required' => 'Lokasi wajib diisi',
            'lokasi.min' => 'Lokasi minimal 3 karakter',
            'ket.required' => 'Keluhan wajib diisi',
            'ket.min' => 'Keluhan minimal 10 karakter',
        ]);

        $user = Auth::user();
        $siswa = Siswa::where('nisn', $user->username)->first();

        if (!$siswa) {
            return redirect()->route('siswa.dashboard')
                ->with('error', 'Data siswa tidak ditemukan.');
        }

        $inputAspirasi = InputAspirasi::with(['aspirasi'])
            ->where('id', $id)
            ->where('id_siswas', $siswa->id)
            ->firstOrFail();

       
        if ($inputAspirasi->aspirasi->status !== 'menunggu') {
            return redirect()->route('siswa.histori')
                ->with('error', 'Aspirasi yang sudah diproses tidak dapat diedit!');
        }

        $inputAspirasi->update([
            'kategoris_id' => $validated['kategoris_id'],
            'lokasi' => $validated['lokasi'],
            'ket' => $validated['ket'],
        ]);

        return redirect()->route('siswa.histori')
            ->with('success', 'Aspirasi berhasil diperbarui!');
    }

    public function destroy($id)
    {
        $user = Auth::user();
        $siswa = Siswa::where('nisn', $user->username)->first();

        if (!$siswa) {
            return redirect()->route('siswa.dashboard')
                ->with('error', 'Data siswa tidak ditemukan.');
        }

        $inputAspirasi = InputAspirasi::with(['aspirasi'])
            ->where('id', $id)
            ->where('id_siswas', $siswa->id)
            ->firstOrFail();

        
        if ($inputAspirasi->aspirasi->status !== 'menunggu') {
            return redirect()->route('siswa.histori')
                ->with('error', 'Aspirasi yang sudah diproses tidak dapat dihapus!');
        }

        DB::beginTransaction();
        try {
            $idPelaporan = $inputAspirasi->id_pelaporan;
            
           
            $inputAspirasi->delete();
            
           
            Aspirasi::where('id_pelaporan', $idPelaporan)->delete();

            DB::commit();

            return redirect()->route('siswa.histori')
                ->with('success', 'Aspirasi berhasil dihapus!');

        } catch (\Exception $e) {
            DB::rollBack();
            
            return back()
                ->with('error', 'Gagal menghapus aspirasi: ' . $e->getMessage());
        }
    }
}