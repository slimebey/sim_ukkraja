@extends('layouts.app')

@section('title', 'Laporan')
@section('page-title', 'Laporan & Histori Aspirasi')

@section('breadcrumb')
  <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">Dashboard</a></li>
  <li class="breadcrumb-item active">Laporan</li>
@endsection

@section('content')
<!-- Filter -->
<div class="card card-primary card-outline">
  <div class="card-header">
    <h3 class="card-title"><i class="fas fa-filter"></i> Filter Laporan</h3>
  </div>
  <form method="GET" action="{{ route('admin.laporan') }}">
    <div class="card-body">
      <div class="row">
        <!-- Tanggal -->
        <div class="col-md-3">
          <div class="form-group">
            <label><i class="fas fa-calendar"></i> Tanggal</label>
            <input type="date" name="tanggal" class="form-control" value="{{ request('tanggal') }}">
          </div>
        </div>

        <!-- Kategori -->
        <div class="col-md-3">
          <div class="form-group">
            <label><i class="fas fa-tag"></i> Kategori</label>
            <select name="kategori" class="form-control">
              <option value="">Semua Kategori</option>
              @foreach($kategoris as $kategori)
                <option value="{{ $kategori->id }}" {{ request('kategori') == $kategori->id ? 'selected' : '' }}>
                  {{ $kategori->ket_kategoris }}
                </option>
              @endforeach
            </select>
          </div>
        </div>

        <!-- Status -->
        <div class="col-md-3">
          <div class="form-group">
            <label><i class="fas fa-info-circle"></i> Status</label>
            <select name="status" class="form-control">
              <option value="">Semua Status</option>
              <option value="menunggu" {{ request('status') == 'menunggu' ? 'selected' : '' }}>Menunggu</option>
              <option value="proses" {{ request('status') == 'proses' ? 'selected' : '' }}>Proses</option>
              <option value="selesai" {{ request('status') == 'selesai' ? 'selected' : '' }}>Selesai</option>
            </select>
          </div>
        </div>

        <!-- Button Actions -->
        <div class="col-md-3">
          <div class="form-group">
            <label>&nbsp;</label>
            <div>
              <button type="submit" class="btn btn-primary">
                <i class="fas fa-search"></i> Filter
              </button>
              <a href="{{ route('admin.laporan') }}" class="btn btn-secondary">
                <i class="fas fa-redo"></i> Reset
              </a>
            </div>
          </div>
        </div>
      </div>
    </div>
  </form>
</div>



<!-- Tabel Laporan -->
<div class="card">
  <div class="card-header">
    <h3 class="card-title">
      <i class="fas fa-table"></i> Detail Laporan 
      <span class="badge badge-primary">{{ $aspirasis->total() }} data</span>
    </h3>
  </div>
  <div class="card-body p-0">
    <div class="table-responsive">
      <table class="table table-striped table-hover">
        <thead>
          <tr>
            <th style="width: 50px;">No</th>
            <th style="width: 110px;">Tanggal</th>
            <th style="width: 100px;">NISN</th>
            <th>Nama</th>
            <th style="width: 100px;">Kelas</th>
            <th style="width: 130px;">Kategori</th>
            <th>Lokasi</th>
            <th style="width: 100px;">Status</th>
            <th style="width: 80px;" class="text-center">Aksi</th>
          </tr>
        </thead>
        <tbody>
          @forelse($aspirasis as $index => $aspirasi)
            <tr>
              <td>{{ $aspirasis->firstItem() + $index }}</td>
              <td>
                <small>
                  <i class="fas fa-calendar"></i> 
                  {{ $aspirasi->tanggal_lapor->format('d/m/Y') }}
                  <br>
                  <i class="fas fa-clock"></i> 
                  {{ $aspirasi->tanggal_lapor->format('H:i') }}
                </small>
              </td>
              <td>{{ $aspirasi->siswa->nisn ?? '-' }}</td>
              <td><strong>{{ $aspirasi->siswa->nama ?? '-' }}</strong></td>
              <td>
                <span class="badge badge-secondary">
                  {{ $aspirasi->siswa->kelas ?? '-' }} {{ $aspirasi->siswa->jurusan ?? '' }}
                </span>
              </td>
              <td>
                <span class="badge badge-info">
                  {{ $aspirasi->kategori->ket_kategoris ?? '-' }}
                </span>
              </td>
              <td>{{ Str::limit($aspirasi->lokasi, 25) }}</td>
              <td>
                @php
                  $status = $aspirasi->aspirasi->status ?? 'menunggu';
                  $badgeClass = match($status) {
                    'menunggu' => 'warning',
                    'proses' => 'info',
                    'selesai' => 'success',
                    default => 'secondary'
                  };
                  $icon = match($status) {
                    'menunggu' => 'clock',
                    'proses' => 'hourglass-half',
                    'selesai' => 'check-circle',
                    default => 'question'
                  };
                @endphp
                <span class="badge badge-{{ $badgeClass }}">
                  <i class="fas fa-{{ $icon }}"></i>
                  {{ ucfirst($status) }}
                </span>
              </td>
              <td class="text-center">
                <a href="{{ route('admin.aspirasi.detail', $aspirasi->id) }}" 
                   class="btn btn-sm btn-primary" 
                   title="Lihat Detail">
                  <i class="fas fa-eye"></i>
                </a>
              </td>
            </tr>
          @empty
            <tr>
              <td colspan="9" class="text-center py-5">
                <i class="fas fa-inbox fa-3x text-muted mb-3"></i>
                <br>
                <span class="text-muted">Tidak ada data untuk periode yang dipilih</span>
              </td>
            </tr>
          @endforelse
        </tbody>
      </table>
    </div>
  </div>
  @if($aspirasis->hasPages())
    <div class="card-footer clearfix">
      <div class="float-right">
        {{ $aspirasis->withQueryString()->links() }}
      </div>
      <div class="float-left">
        <small class="text-muted">
          Menampilkan {{ $aspirasis->firstItem() }} - {{ $aspirasis->lastItem() }} 
          dari {{ $aspirasis->total() }} data
        </small>
      </div>
    </div>
  @endif
</div>
@endsection