@extends('layouts.app')

@section('title', 'Detail Aspirasi')
@section('page-title', 'Detail Aspirasi #' . $inputAspirasi->id_pelaporan)

@section('breadcrumb')
  <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">Dashboard</a></li>
  <li class="breadcrumb-item"><a href="{{ route('admin.aspirasi.index') }}">Daftar Aspirasi</a></li>
  <li class="breadcrumb-item active">Detail</li>
@endsection

@section('content')
@if(session('success'))
  <div class="alert alert-success alert-dismissible">
    <button type="button" class="close" data-dismiss="alert">&times;</button>
    <i class="icon fas fa-check"></i> {{ session('success') }}
  </div>
@endif

<div class="row">
  <!-- Detail Aspirasi -->
  <div class="col-md-8">
    <div class="card card-primary card-outline">
      <div class="card-header">
        <h3 class="card-title">Informasi Aspirasi</h3>
      </div>
      <div class="card-body">
        <!-- Status Badge -->
        <div class="mb-3">
          @php
            $badgeClass = match($inputAspirasi->aspirasi->status ?? 'menunggu') {
              'menunggu' => 'warning',
              'proses' => 'info',
              'selesai' => 'success',
              default => 'secondary'
            };
          @endphp
          <h5>Status: 
            <span class="badge badge-{{ $badgeClass }} badge-lg">
              {{ ucfirst($inputAspirasi->aspirasi->status ?? 'menunggu') }}
            </span>
          </h5>
        </div>

        <table class="table table-bordered">
          <tr>
            <th width="200">ID Pelaporan</th>
            <td>#{{ $inputAspirasi->id_pelaporan }}</td>
          </tr>
          <tr>
            <th>Tanggal Lapor</th>
            <td>
              <i class="fas fa-calendar"></i> 
              {{ $inputAspirasi->tanggal_lapor->format('l, d F Y') }}
              <span class="text-muted">{{ $inputAspirasi->tanggal_lapor->format('H:i') }} WIB</span>
            </td>
          </tr>
          <tr>
            <th>Kategori</th>
            <td>
              <span class="badge badge-secondary">
                {{ $inputAspirasi->kategori->ket_kategoris ?? '-' }}
              </span>
            </td>
          </tr>
          <tr>
            <th>Lokasi</th>
            <td>
              <i class="fas fa-map-marker-alt"></i> {{ $inputAspirasi->lokasi }}
            </td>
          </tr>
        </table>

        <div class="mt-3">
          <label><strong>Keluhan / Keterangan:</strong></label>
          <div class="callout callout-secondary">
            {{ $inputAspirasi->ket }}
          </div>
        </div>

        <!-- Current Feedback -->
        @if($inputAspirasi->aspirasi && $inputAspirasi->aspirasi->feedback)
          <div class="callout callout-info">
            <h6><i class="fas fa-comment-dots"></i> Feedback Saat Ini</h6>
            <hr>
            <p class="mb-2">{{ $inputAspirasi->aspirasi->feedback }}</p>
            <small class="text-muted">
              <i class="fas fa-calendar"></i> 
              {{ $inputAspirasi->aspirasi->tanggal_feedback->format('d F Y, H:i') }} WIB
            </small>
          </div>
        @endif
      </div>
    </div>

    <!-- Form Update Status & Feedback -->
    <div class="card card-warning">
      <div class="card-header">
        <h3 class="card-title"><i class="fas fa-edit"></i> Kelola Aspirasi</h3>
      </div>
      <div class="card-body">
        <!-- Quick Status Update -->
        <div class="mb-3">
          <label><strong>Ubah Status Cepat:</strong></label>
          <form method="POST" action="{{ route('admin.aspirasi.update-status', $inputAspirasi->id) }}" class="d-inline">
            @csrf
            <div class="btn-group" role="group">
              <button type="submit" name="status" value="menunggu" class="btn btn-{{ $inputAspirasi->aspirasi->status == 'menunggu' ? 'warning' : 'outline-warning' }}">
                <i class="fas fa-clock"></i> Menunggu
              </button>
              <button type="submit" name="status" value="proses" class="btn btn-{{ $inputAspirasi->aspirasi->status == 'proses' ? 'info' : 'outline-info' }}">
                <i class="fas fa-hourglass-half"></i> Proses
              </button>
              <button type="submit" name="status" value="selesai" class="btn btn-{{ $inputAspirasi->aspirasi->status == 'selesai' ? 'success' : 'outline-success' }}">
                <i class="fas fa-check"></i> Selesai
              </button>
            </div>
          </form>
        </div>

        <hr>

        <!-- Form Feedback -->
        <form method="POST" action="{{ route('admin.aspirasi.feedback', $inputAspirasi->id) }}">
          @csrf
          <div class="form-group">
            <label>Feedback untuk Siswa <span class="text-danger">*</span></label>
            <textarea name="feedback" 
                      class="form-control @error('feedback') is-invalid @enderror" 
                      rows="5" 
                      placeholder="Berikan feedback atau keterangan tindak lanjut..."
                      required>{{ old('feedback', $inputAspirasi->aspirasi->feedback ?? '') }}</textarea>
            @error('feedback')
              <span class="invalid-feedback">{{ $message }}</span>
            @enderror
            <small class="form-text text-muted">Minimal 10 karakter</small>
          </div>

          <div class="form-group">
            <label>Status <span class="text-danger">*</span></label>
            <select name="status" class="form-control @error('status') is-invalid @enderror" required>
              <option value="proses" {{ old('status', $inputAspirasi->aspirasi->status) == 'proses' ? 'selected' : '' }}>
                Proses
              </option>
              <option value="selesai" {{ old('status', $inputAspirasi->aspirasi->status) == 'selesai' ? 'selected' : '' }}>
                Selesai
              </option>
            </select>
            @error('status')
              <span class="invalid-feedback">{{ $message }}</span>
            @enderror
          </div>

          <button type="submit" class="btn btn-primary">
            <i class="fas fa-paper-plane"></i> Kirim Feedback
          </button>
          <a href="{{ route('admin.aspirasi.index') }}" class="btn btn-secondary">
            <i class="fas fa-arrow-left"></i> Kembali
          </a>
        </form>
      </div>
    </div>
  </div>

  <!-- Sidebar Info -->
  <div class="col-md-4">
    <!-- Info Pelapor -->
    <div class="card card-widget widget-user">
      <div class="widget-user-header bg-info">
        <h3 class="widget-user-username">{{ $inputAspirasi->siswa->nama ?? '-' }}</h3>
        <h5 class="widget-user-desc">{{ $inputAspirasi->siswa->nisn ?? '-' }}</h5>
      </div>
      <div class="widget-user-image">
        <img class="img-circle elevation-2" src="{{ asset('dist/img/user2-160x160.jpg') }}" alt="User Avatar">
      </div>
      <div class="card-footer">
        <div class="row">
          <div class="col-sm-12">
            <div class="description-block">
              <h5 class="description-header">Kelas</h5>
              <span class="description-text">{{ $inputAspirasi->siswa->kelas ?? '-' }} {{ $inputAspirasi->siswa->jurusan ?? '' }}</span>
            </div>
          </div>
        </div>
      </div>
    </div>

    <!-- Timeline -->
    <div class="card">
      <div class="card-header">
        <h3 class="card-title"><i class="fas fa-history"></i> Timeline</h3>
      </div>
      <div class="card-body">
        <div class="timeline">
          <div>
            <i class="fas fa-file-alt bg-primary"></i>
            <div class="timeline-item">
              <span class="time"><i class="fas fa-clock"></i> {{ $inputAspirasi->tanggal_lapor->diffForHumans() }}</span>
              <h3 class="timeline-header">Dilaporkan</h3>
              <div class="timeline-body">
                {{ $inputAspirasi->tanggal_lapor->format('d M Y, H:i') }}
              </div>
            </div>
          </div>

          @if($inputAspirasi->aspirasi && $inputAspirasi->aspirasi->tanggal_feedback)
          <div>
            <i class="fas fa-comment bg-info"></i>
            <div class="timeline-item">
              <span class="time"><i class="fas fa-clock"></i> {{ $inputAspirasi->aspirasi->tanggal_feedback->diffForHumans() }}</span>
              <h3 class="timeline-header">Feedback</h3>
              <div class="timeline-body">
                {{ $inputAspirasi->aspirasi->tanggal_feedback->format('d M Y, H:i') }}
              </div>
            </div>
          </div>
          @endif

          @if($inputAspirasi->aspirasi && $inputAspirasi->aspirasi->status === 'selesai')
          <div>
            <i class="fas fa-check bg-success"></i>
            <div class="timeline-item">
              <h3 class="timeline-header">Selesai</h3>
              <div class="timeline-body">
                Ditangani dengan baik
              </div>
            </div>
          </div>
          @endif
        </div>
      </div>
    </div>
  </div>
</div>
@endsection

@push('styles')
<link rel="stylesheet" href="{{ asset('plugins/ekko-lightbox/ekko-lightbox.css') }}">
@endpush