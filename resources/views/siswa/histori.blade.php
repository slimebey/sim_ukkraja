@extends('layouts.app')

@section('title', 'Histori Aspirasi')
@section('page-title', 'Histori Aspirasi')

@section('breadcrumb')
  <li class="breadcrumb-item"><a href="{{ route('siswa.dashboard') }}">Dashboard</a></li>
  <li class="breadcrumb-item active">Histori</li>
@endsection

@section('content')
@if(session('success'))
  <div class="alert alert-success alert-dismissible">
    <button type="button" class="close" data-dismiss="alert">&times;</button>
    <i class="icon fas fa-check"></i> {{ session('success') }}
  </div>
@endif

@if(session('error'))
  <div class="alert alert-danger alert-dismissible">
    <button type="button" class="close" data-dismiss="alert">&times;</button>
    <i class="icon fas fa-times"></i> {{ session('error') }}
  </div>
@endif

<!-- Statistics -->
<div class="row">
  <div class="col-lg-3 col-6">
    <div class="small-box bg-primary">
      <div class="inner">
        <h3>{{ $stats['total'] }}</h3>
        <p>Total</p>
      </div>
      <div class="icon">
        <i class="fas fa-clipboard-list"></i>
      </div>
      <a href="{{ route('siswa.buat') }}" class="small-box-footer">
        Buat Baru <i class="fas fa-plus-circle"></i>
      </a>
    </div>
  </div>
  <div class="col-lg-3 col-6">
    <div class="small-box bg-warning">
      <div class="inner">
        <h3>{{ $stats['menunggu'] }}</h3>
        <p>Menunggu</p>
      </div>
      <div class="icon">
        <i class="fas fa-clock"></i>
      </div>
    </div>
  </div>
  <div class="col-lg-3 col-6">
    <div class="small-box bg-info">
      <div class="inner">
        <h3>{{ $stats['proses'] }}</h3>
        <p>Proses</p>
      </div>
      <div class="icon">
        <i class="fas fa-hourglass-half"></i>
      </div>
    </div>
  </div>
  <div class="col-lg-3 col-6">
    <div class="small-box bg-success">
      <div class="inner">
        <h3>{{ $stats['selesai'] }}</h3>
        <p>Selesai</p>
      </div>
      <div class="icon">
        <i class="fas fa-check-circle"></i>
      </div>
    </div>
  </div>
</div>

<!-- List Aspirasi -->
<div class="row">
  <div class="col-12">
    @forelse($aspirasis as $aspirasi)
      <div class="card">
        <div class="card-body">
          <div class="row">
            <div class="col-md-9">
              <h5>
                <span class="badge badge-secondary">
                  {{ $aspirasi->kategori->ket_kategoris ?? '-' }}
                </span>
                {{ $aspirasi->lokasi }}
                @if($aspirasi->aspirasi->status === 'menunggu')
                  <span class="badge badge-pill badge-warning">
                    <i class="fas fa-edit"></i> Dapat diedit
                  </span>
                @endif
              </h5>
              <p class="mb-2">{{ \Str::limit($aspirasi->ket, 150) }}</p>
              <small class="text-muted">
                <i class="fas fa-calendar"></i> {{ $aspirasi->tanggal_lapor->format('d M Y, H:i') }}
              </small>
            </div>
            <div class="col-md-3 text-right">
              @php
                $statusClass = match($aspirasi->aspirasi->status ?? 'menunggu') {
                  'menunggu' => 'warning',
                  'proses' => 'info',
                  'selesai' => 'success',
                  default => 'secondary'
                };
              @endphp
              <span class="badge badge-{{ $statusClass }} badge-lg mb-2 d-block">
                {{ ucfirst($aspirasi->aspirasi->status ?? 'menunggu') }}
              </span>
              
              <div class="btn-group d-block mb-2">
                <a href="{{ route('siswa.show', $aspirasi->id) }}" 
                   class="btn btn-primary btn-sm"
                   title="Lihat Detail">
                  <i class="fas fa-eye"></i> Detail
                </a>
                
                @if($aspirasi->aspirasi->status === 'menunggu')
                  <a href="{{ route('siswa.edit', $aspirasi->id) }}" 
                     class="btn btn-warning btn-sm"
                     title="Edit">
                    <i class="fas fa-edit"></i> Edit
                  </a>
                @endif
              </div>

              @if($aspirasi->aspirasi->status === 'menunggu')
                <form action="{{ route('siswa.destroy', $aspirasi->id) }}" 
                      method="POST" 
                      class="d-inline"
                      onsubmit="return confirm('Yakin ingin menghapus aspirasi ini?')">
                  @csrf
                  @method('DELETE')
                  <button type="submit" 
                          class="btn btn-danger btn-sm btn-block"
                          title="Hapus">
                    <i class="fas fa-trash"></i> Hapus
                  </button>
                </form>
              @endif
            </div>
          </div>

          @if($aspirasi->aspirasi && $aspirasi->aspirasi->feedback)
            <div class="callout callout-info mt-3">
              <h6><i class="fas fa-comment-dots"></i> Feedback Admin:</h6>
              <p class="mb-1">{{ $aspirasi->aspirasi->feedback }}</p>
              <small class="text-muted">
                <i class="fas fa-calendar"></i> {{ $aspirasi->aspirasi->tanggal_feedback->format('d M Y, H:i') }}
              </small>
            </div>
          @endif
        </div>
      </div>
    @empty
      <div class="card">
        <div class="card-body">
          <div class="text-center py-5">
            <i class="fas fa-inbox fa-3x text-muted mb-3"></i>
            <h5 class="text-muted">Belum ada aspirasi</h5>
            <p class="text-muted">Anda belum pernah membuat aspirasi</p>
            <a href="{{ route('siswa.buat') }}" class="btn btn-primary">
              <i class="fas fa-plus"></i> Buat Aspirasi Pertama
            </a>
          </div>
        </div>
      </div>
    @endforelse

    @if($aspirasis->hasPages())
      <div class="d-flex justify-content-center">
        {{ $aspirasis->links() }}
      </div>
    @endif
  </div>
</div>

<!-- Info Box -->
<div class="row">
  <div class="col-12">
    <div class="callout callout-info">
      <h5><i class="fas fa-info-circle"></i> Informasi:</h5>
      <ul class="mb-0 pl-3">
        <li>Anda hanya dapat mengedit atau menghapus aspirasi yang statusnya <strong>"Menunggu"</strong></li>
        <li>Aspirasi yang sudah diproses atau selesai tidak dapat diubah</li>
        <li>Pastikan informasi yang Anda berikan akurat sebelum admin memproses</li>
      </ul>
    </div>
  </div>
</div>
@endsection