@extends('layouts.app')

@section('title', 'Dashboard Admin')
@section('page-title', 'Dashboard Admin')

@section('breadcrumb')
  <li class="breadcrumb-item active">Dashboard</li>
@endsection

@section('content')
<!-- Alert Success -->
@if(session('success'))
  <div class="alert alert-success alert-dismissible">
    <button type="button" class="close" data-dismiss="alert">&times;</button>
    <i class="icon fas fa-check"></i> {{ session('success') }}
  </div>
@endif

<!-- Statistics Cards -->
<div class="row">
  <div class="col-lg-3 col-6">
    <div class="small-box bg-info">
      <div class="inner">
        <h3>{{ $stats['total_siswa'] ?? 0 }}</h3>
        <p>Total Siswa</p>
      </div>
      <div class="icon">
        <i class="fas fa-users"></i>
      </div>
      <a href="#" class="small-box-footer">More info <i class="fas fa-arrow-circle-right"></i></a>
    </div>
  </div>

  <div class="col-lg-3 col-6">
    <div class="small-box bg-primary">
      <div class="inner">
        <h3>{{ $stats['total_aspirasi'] ?? 0 }}</h3>
        <p>Total Aspirasi</p>
      </div>
      <div class="icon">
        <i class="fas fa-clipboard-check"></i>
      </div>
      <a href="{{ route('admin.aspirasi.index') }}" class="small-box-footer">More info <i class="fas fa-arrow-circle-right"></i></a>
    </div>
  </div>

  <div class="col-lg-3 col-6">
    <div class="small-box bg-warning">
      <div class="inner">
        <h3>{{ $stats['menunggu'] ?? 0 }}</h3>
        <p>Menunggu</p>
      </div>
      <div class="icon">
        <i class="fas fa-clock"></i>
      </div>
      <a href="{{ route('admin.aspirasi.index', ['status' => 'menunggu']) }}" class="small-box-footer">More info <i class="fas fa-arrow-circle-right"></i></a>
    </div>
  </div>

  <div class="col-lg-3 col-6">
    <div class="small-box bg-success">
      <div class="inner">
        <h3>{{ $stats['selesai'] ?? 0 }}</h3>
        <p>Selesai</p>
      </div>
      <div class="icon">
        <i class="fas fa-check-circle"></i>
      </div>
      <a href="{{ route('admin.aspirasi.index', ['status' => 'selesai']) }}" class="small-box-footer">More info <i class="fas fa-arrow-circle-right"></i></a>
    </div>
  </div>
</div>

<!-- Aspirasi Terbaru -->
<div class="row">
  <div class="col-12">
    <div class="card">
      <div class="card-header">
        <h3 class="card-title">Aspirasi Terbaru</h3>
        <div class="card-tools">
          <a href="{{ route('admin.aspirasi.index') }}" class="btn btn-primary btn-sm">
            <i class="fas fa-eye"></i> Lihat Semua
          </a>
        </div>
      </div>
      <div class="card-body p-0">
        <table class="table table-striped">
          <thead>
            <tr>
              <th>Tanggal</th>
              <th>NISN</th>
              <th>Nama Siswa</th>
              <th>Kategori</th>
              <th>Lokasi</th>
              <th>Status</th>
              <th>Aksi</th>
            </tr>
          </thead>
          <tbody>
            @forelse($aspirasiTerbaru ?? [] as $aspirasi)
              <tr>
                <td>{{ $aspirasi->tanggal_lapor->format('d/m/Y') }}</td>
                <td>{{ $aspirasi->siswa->nisn ?? '-' }}</td>
                <td>{{ $aspirasi->siswa->nama ?? '-' }}</td>
                <td>
                  <span class="badge badge-secondary">
                    {{ $aspirasi->kategori->ket_kategoris ?? '-' }}
                  </span>
                </td>
                <td>{{ Str::limit($aspirasi->lokasi, 20) }}</td>
                <td>
                  @php
                    $badgeClass = match($aspirasi->aspirasi->status ?? 'menunggu') {
                      'menunggu' => 'warning',
                      'proses' => 'info',
                      'selesai' => 'success',
                      default => 'secondary'
                    };
                  @endphp
                  <span class="badge badge-{{ $badgeClass }}">
                    {{ ucfirst($aspirasi->aspirasi->status ?? 'menunggu') }}
                  </span>
                </td>
                <td>
                  <a href="{{ route('admin.aspirasi.detail', $aspirasi->id) }}" class="btn btn-sm btn-primary">
                    <i class="fas fa-eye"></i> Detail
                  </a>
                </td>
              </tr>
            @empty
              <tr>
                <td colspan="7" class="text-center">Belum ada data aspirasi</td>
              </tr>
            @endforelse
          </tbody>
        </table>
      </div>
    </div>
  </div>
</div>
@endsection