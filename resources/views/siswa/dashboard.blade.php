@extends('layouts.app')

@section('title', 'Dashboard Siswa')
@section('page-title', 'Dashboard Siswa')

@section('breadcrumb')
  <li class="breadcrumb-item active">Dashboard</li>
@endsection

@section('content')
@if(session('success'))
  <div class="alert alert-success alert-dismissible">
    <button type="button" class="close" data-dismiss="alert">&times;</button>
    <i class="icon fas fa-check"></i> {{ session('success') }}
  </div>
@endif


    <!-- Statistics -->
    <div class="row">
      <div class="col-md-3 col-sm-6 col-12">
        <div class="info-box">
          <span class="info-box-icon bg-primary"><i class="fas fa-clipboard-list"></i></span>
          <div class="info-box-content">
            <span class="info-box-text">Total</span>
            <span class="info-box-number">{{ $stats['total'] ?? 0 }}</span>
          </div>
        </div>
      </div>

      <div class="col-md-3 col-sm-6 col-12">
        <div class="info-box">
          <span class="info-box-icon bg-warning"><i class="fas fa-clock"></i></span>
          <div class="info-box-content">
            <span class="info-box-text">Menunggu</span>
            <span class="info-box-number">{{ $stats['menunggu'] ?? 0 }}</span>
          </div>
        </div>
      </div>

      <div class="col-md-3 col-sm-6 col-12">
        <div class="info-box">
          <span class="info-box-icon bg-info"><i class="fas fa-hourglass-half"></i></span>
          <div class="info-box-content">
            <span class="info-box-text">Proses</span>
            <span class="info-box-number">{{ $stats['proses'] ?? 0 }}</span>
          </div>
        </div>
      </div>

      <div class="col-md-3 col-sm-6 col-12">
        <div class="info-box">
          <span class="info-box-icon bg-success"><i class="fas fa-check-circle"></i></span>
          <div class="info-box-content">
            <span class="info-box-text">Selesai</span>
            <span class="info-box-number">{{ $stats['selesai'] ?? 0 }}</span>
          </div>
        </div>
      </div>
    </div>

    <!-- Quick Actions -->
    <div class="card">
      <div class="card-header">
        <h3 class="card-title">Aksi Cepat</h3>
      </div>
      <div class="card-body">
        <div class="row">
          <div class="col-md-6">
            <a href="{{ route('siswa.buat') }}" class="btn btn-primary btn-lg btn-block">
              <i class="fas fa-plus-circle"></i> Buat Aspirasi Baru
            </a>
          </div>
          <div class="col-md-6">
            <a href="{{ route('siswa.histori') }}" class="btn btn-outline-primary btn-lg btn-block">
              <i class="fas fa-history"></i> Lihat Histori
            </a>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>

<!-- Aspirasi Terbaru -->
<div class="row">
  <div class="col-12">
    <div class="card">
      <div class="card-header">
        <h3 class="card-title">Aspirasi Terbaru</h3>
      </div>
      <div class="card-body">
        @forelse($aspirasiTerbaru ?? [] as $aspirasi)
          <div class="callout callout-info">
            <h5>
              <span class="badge badge-secondary">{{ $aspirasi->kategori->ket_kategoris ?? '-' }}</span>
              {{ $aspirasi->lokasi }}
            </h5>
            <p>{{ \Str::limit($aspirasi->ket, 100) }}</p>
            <small class="text-muted">
              <i class="fas fa-calendar"></i> {{ $aspirasi->tanggal_lapor->format('d M Y, H:i') }}
              <span class="mx-2">|</span>
              Status: 
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
            </small>
          </div>
        @empty
          <div class="text-center text-muted py-5">
            <i class="fas fa-inbox fa-3x mb-3"></i>
            <p>Belum ada aspirasi</p>
          </div>
        @endforelse
      </div>
    </div>
  </div>
</div>
@endsection