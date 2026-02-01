<?php

namespace App\Http\Controllers;

use App\Models\InputAspirasi;
use App\Models\Aspirasi;
use App\Models\Kategori;
use App\Models\Siswa;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class AdminController extends Controller 
{
    public function dashboard()
    {
        $stats = [
            'total_siswa' => Siswa::count(),
            'total_aspirasi' => InputAspirasi::count(),
            'total_kategori' => Kategori::count(),
            'menunggu' => Aspirasi::where('status', 'menunggu')->count(),
            'proses' => Aspirasi::where('status', 'proses')->count(),
            'selesai' => Aspirasi::where('status', 'selesai')->count(),
        ];

        $aspirasiTerbaru = InputAspirasi::with(['siswa', 'kategori', 'aspirasi'])
            ->latest('tanggal_lapor')
            ->limit(5)
            ->get();

        return view('admin.dashboard', compact('stats', 'aspirasiTerbaru'));
    }

    public function daftarAspirasi(Request $request)
    {
        $query = InputAspirasi::with(['siswa', 'kategori', 'aspirasi']);

        if ($request->filled('tanggal')) {
            $query->whereDate('tanggal_lapor', $request->tanggal);
        }

        if ($request->filled('bulan')) {
            $query->whereMonth('tanggal_lapor', $request->bulan);
        }

        if ($request->filled('tahun')) {
            $query->whereYear('tanggal_lapor', $request->tahun);
        }

        if ($request->filled('siswa')) {
            $query->where('id_siswas', $request->siswa);
        }

        if ($request->filled('kategori')) {
            $query->where('kategoris_id', $request->kategori);
        }

        if ($request->filled('status')) {
            $query->whereHas('aspirasi', function($q) use ($request) {
                $q->where('status', $request->status);
            });
        }

        $aspirasis = $query->latest('tanggal_lapor')->paginate(10);

        $siswas = Siswa::orderBy('nama')->get();
        $kategoris = Kategori::all();

        return view('admin.index', compact('aspirasis', 'siswas', 'kategoris'));
    }

    public function detailAspirasi($id)
    {
        $inputAspirasi = InputAspirasi::with(['siswa', 'kategori', 'aspirasi'])
            ->findOrFail($id);

        return view('admin.detail', compact('inputAspirasi'));
    }

    public function updateStatus(Request $request, $id)
    {
        $validated = $request->validate([
            'status' => 'required|in:menunggu,proses,selesai',
        ]);

        $inputAspirasi = InputAspirasi::findOrFail($id);
        $aspirasi = $inputAspirasi->aspirasi;

        $aspirasi->update([
            'status' => $validated['status'],
        ]);

        return back()->with('success', 'Status berhasil diubah menjadi ' . ucfirst($validated['status']));
    }

    public function beriFeedback(Request $request, $id)
    {
        $validated = $request->validate([
            'feedback' => 'required|string|min:10',
            'status' => 'required|in:proses,selesai',
        ], [
            'feedback.required' => 'Feedback wajib diisi',
            'feedback.min' => 'Feedback minimal 10 karakter',
            'status.required' => 'Status wajib dipilih',
        ]);

        $inputAspirasi = InputAspirasi::findOrFail($id);
        $aspirasi = $inputAspirasi->aspirasi;

        $aspirasi->update([
            'status' => $validated['status'],
            'feedback' => $validated['feedback'],
            'tanggal_feedback' => now(),
        ]);

        return back()->with('success', 'Feedback berhasil diberikan!');
    }

    public function laporan(Request $request)
    {
        $query = InputAspirasi::with(['siswa', 'kategori', 'aspirasi']);

        if ($request->filled('tanggal')) {
            $query->whereDate('tanggal_lapor', $request->tanggal);
        }

        if ($request->filled('kategori')) {
            $query->where('kategoris_id', $request->kategori);
        }

        if ($request->filled('status')) {
            $query->whereHas('aspirasi', function($q) use ($request) {
                $q->where('status', $request->status);
            });
        }

        $aspirasis = $query->latest('tanggal_lapor')->paginate(20);

        $baseQuery = InputAspirasi::with(['aspirasi']);
        
        if ($request->filled('tanggal')) {
            $baseQuery->whereDate('tanggal_lapor', $request->tanggal);
        }

        if ($request->filled('kategori')) {
            $baseQuery->where('kategoris_id', $request->kategori);
        }

        $stats = [
            'total' => $baseQuery->count(),
            'menunggu' => (clone $baseQuery)->whereHas('aspirasi', fn($q) => $q->where('status', 'menunggu'))->count(),
            'proses' => (clone $baseQuery)->whereHas('aspirasi', fn($q) => $q->where('status', 'proses'))->count(),
            'selesai' => (clone $baseQuery)->whereHas('aspirasi', fn($q) => $q->where('status', 'selesai'))->count(),
        ];

        $kategoris = Kategori::all();

        return view('admin.laporan', compact('aspirasis', 'stats', 'kategoris'));
    }
}