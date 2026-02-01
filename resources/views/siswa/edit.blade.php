@extends('layouts.app')

@section('title', 'Edit Aspirasi')
@section('page-title', 'Edit Aspirasi')

@section('breadcrumb')
  <li class="breadcrumb-item"><a href="{{ route('siswa.dashboard') }}">Dashboard</a></li>
  <li class="breadcrumb-item"><a href="{{ route('siswa.histori') }}">Histori</a></li>
  <li class="breadcrumb-item active">Edit</li>
@endsection

@section('content')
<div class="row">
  <div class="col-md-8">
    <div class="card card-warning">
      <div class="card-header">
        <h3 class="card-title">Form Edit Aspirasi</h3>
      </div>
      
      <form method="POST" action="{{ route('siswa.update', $inputAspirasi->id) }}">
        @csrf
        @method('PUT')
        <div class="card-body">
          @if(session('error'))
            <div class="alert alert-danger alert-dismissible">
              <button type="button" class="close" data-dismiss="alert">&times;</button>
              {{ session('error') }}
            </div>
          @endif

          <!-- Info Aspirasi -->
          <div class="callout callout-info">
            <h6><i class="fas fa-info-circle"></i> Informasi Aspirasi</h6>
            <table class="table table-sm mb-0">
              <tr>
                <th width="150">ID Pelaporan</th>
                <td>#{{ $inputAspirasi->id_pelaporan }}</td>
              </tr>
              <tr>
                <th>Tanggal Lapor</th>
                <td>{{ $inputAspirasi->tanggal_lapor->format('d F Y, H:i') }} WIB</td>
              </tr>
              <tr>
                <th>Status</th>
                <td>
                  <span class="badge badge-warning">
                    {{ ucfirst($inputAspirasi->aspirasi->status) }}
                  </span>
                </td>
              </tr>
            </table>
          </div>

          <!-- Kategori -->
          <div class="form-group">
            <label for="kategoris_id">Kategori Pengaduan <span class="text-danger">*</span></label>
            <select name="kategoris_id" id="kategoris_id" class="form-control @error('kategoris_id') is-invalid @enderror" required>
              <option value="">-- Pilih Kategori --</option>
              @foreach($kategoris as $kategori)
                <option value="{{ $kategori->id }}" 
                        {{ old('kategoris_id', $inputAspirasi->kategoris_id) == $kategori->id ? 'selected' : '' }}>
                  {{ $kategori->ket_kategoris }}
                </option>
              @endforeach
            </select>
            @error('kategoris_id')
              <span class="invalid-feedback">{{ $message }}</span>
            @enderror
            <small class="form-text text-muted">Pilih kategori yang sesuai dengan pengaduan Anda</small>
          </div>

          <!-- Lokasi -->
          <div class="form-group">
            <label for="lokasi">Lokasi Fasilitas <span class="text-danger">*</span></label>
            <input type="text" 
                   name="lokasi" 
                   id="lokasi" 
                   class="form-control @error('lokasi') is-invalid @enderror" 
                   value="{{ old('lokasi', $inputAspirasi->lokasi) }}"
                   placeholder="Contoh: Ruang Kelas XII RPL 1, Lab Komputer, dll"
                   required>
            @error('lokasi')
              <span class="invalid-feedback">{{ $message }}</span>
            @enderror
            <small class="form-text text-muted">Sebutkan lokasi spesifik dari fasilitas yang bermasalah</small>
          </div>

          <!-- Keluhan Detail -->
          <div class="form-group">
            <label for="ket">Keluhan / Keterangan Detail <span class="text-danger">*</span></label>
            <textarea name="ket" 
                      id="ket" 
                      rows="6" 
                      class="form-control @error('ket') is-invalid @enderror" 
                      placeholder="Jelaskan masalah secara detail..."
                      required>{{ old('ket', $inputAspirasi->ket) }}</textarea>
            @error('ket')
              <span class="invalid-feedback">{{ $message }}</span>
            @enderror
            <small class="form-text text-muted">Minimal 10 karakter. Semakin detail, semakin mudah admin memahami masalahnya.</small>
          </div>
        </div>

        <div class="card-footer">
          <button type="submit" class="btn btn-warning">
            <i class="fas fa-save"></i> Update Aspirasi
          </button>
          <a href="{{ route('siswa.histori') }}" class="btn btn-secondary">
            <i class="fas fa-times"></i> Batal
          </a>
          <a href="{{ route('siswa.show', $inputAspirasi->id) }}" class="btn btn-info">
            <i class="fas fa-eye"></i> Lihat Detail
          </a>
        </div>
      </form>
    </div>
  </div>

  <!-- Panduan -->
  <div class="col-md-4">
    <div class="card card-warning">
      <div class="card-header">
        <h3 class="card-title"><i class="fas fa-exclamation-triangle"></i> Perhatian!</h3>
      </div>
      <div class="card-body">
        <ul class="pl-3">
          <li class="mb-2">Anda sedang mengedit aspirasi yang sudah dilaporkan</li>
          <li class="mb-2">Perubahan akan menggantikan data sebelumnya</li>
          <li class="mb-2">Pastikan semua informasi sudah benar</li>
          <li class="mb-2">Aspirasi yang sudah diproses tidak dapat diedit</li>
          <li>Admin akan melihat versi terbaru dari aspirasi Anda</li>
        </ul>
      </div>
    </div>

    <div class="card card-info">
      <div class="card-header">
        <h3 class="card-title"><i class="fas fa-lightbulb"></i> Tips</h3>
      </div>
      <div class="card-body">
        <ul class="pl-3">
          <li class="mb-2">Periksa kembali kategori yang dipilih</li>
          <li class="mb-2">Pastikan lokasi sudah spesifik dan jelas</li>
          <li class="mb-2">Tambahkan detail yang mungkin terlewat</li>
          <li>Gunakan bahasa yang sopan dan jelas</li>
        </ul>
      </div>
    </div>
  </div>
</div>
@endsection