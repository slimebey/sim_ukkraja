    @extends('layouts.app')

@section('title', 'Buat Aspirasi')
@section('page-title', 'Buat Aspirasi Baru')

@section('breadcrumb')
  <li class="breadcrumb-item"><a href="{{ route('siswa.dashboard') }}">Dashboard</a></li>
  <li class="breadcrumb-item active">Buat Aspirasi</li>
@endsection

@section('content')
<div class="row">
  <div class="col-md-8">
    <div class="card card-primary">
      <div class="card-header">
        <h3 class="card-title">Form Pengaduan Sarana & Prasarana</h3>
      </div>
      
      <form method="POST" action="{{ route('siswa.store') }}">
        @csrf
        <div class="card-body">
          @if(session('error'))
            <div class="alert alert-danger alert-dismissible">
              <button type="button" class="close" data-dismiss="alert">&times;</button>
              {{ session('error') }}
            </div>
          @endif

          <!-- Kategori -->
          <div class="form-group">
            <label for="kategoris_id">Kategori Pengaduan <span class="text-danger">*</span></label>
            <select name="kategoris_id" id="kategoris_id" class="form-control @error('kategoris_id') is-invalid @enderror" required>
              <option value="">-- Pilih Kategori --</option>
              @foreach($kategoris as $kategori)
                <option value="{{ $kategori->id }}" {{ old('kategoris_id') == $kategori->id ? 'selected' : '' }}>
                  {{ $kategori->ket_kategoris }}
                </option>
              @endforeach
            </select>
            @error('kategoris_id')
              <span class="invalid-feedback">{{ $message }}</span>
            @enderror
            <small class="form-text text-muted"></small>
          </div>

          <!-- Lokasi -->
          <div class="form-group">
            <label for="lokasi">Lokasi Fasilitas <span class="text-danger">*</span></label>
            <input type="text" 
                   name="lokasi" 
                   id="lokasi" 
                   class="form-control @error('lokasi') is-invalid @enderror" 
                   value="{{ old('lokasi') }}"
                   placeholder=""
                   required>
            @error('lokasi')
              <span class="invalid-feedback">{{ $message }}</span>
            @enderror
            <small class="form-text text-muted"></small>
          </div>

          <!-- Keluhan Detail -->
          <div class="form-group">
            <label for="ket">Keluhan / Keterangan Detail <span class="text-danger">*</span></label>
            <textarea name="ket" 
                      id="ket" 
                      rows="6" 
                      class="form-control @error('ket') is-invalid @enderror" 
                      placeholder=""
                      required>{{ old('ket') }}</textarea>
            @error('ket')
              <span class="invalid-feedback">{{ $message }}</span>
            @enderror
            <small class="form-text text-muted">Minimal 10 karakter. Semakin detail, semakin mudah admin memahami masalahnya.</small>
          </div>
        </div>

        <div class="card-footer">
          <button type="submit" class="btn btn-primary">
            <i class="fas fa-paper-plane"></i> Kirim Aspirasi
          </button>
          <a href="{{ route('siswa.dashboard') }}" class="btn btn-secondary">
            <i class="fas fa-times"></i> Batal
          </a>
        </div>
      </form>
    </div>
  </div>

  <!-- Panduan -->
  <div class="col-md-4">
    <div class="card card-info">
      <div class="card-header">
        <h3 class="card-title"><i class="fas fa-lightbulb"></i> Tips Mengisi Form</h3>
      </div>
      <div class="card-body">
        <ol class="pl-3">
          <li class="mb-2">Pilih kategori yang paling sesuai</li>
          <li class="mb-2">Tulis lokasi dengan jelas dan spesifik</li>
          <li class="mb-2">Jelaskan masalah secara detail</li>
          <li class="mb-2">Sertakan kapan masalah mulai terjadi</li>
          <li>Tunggu feedback dari admin</li>
        </ol>
      </div>
    </div>

    <div class="callout callout-warning">
      <h5><i class="fas fa-exclamation-triangle"></i> Perhatian!</h5>
      <p class="mb-0">Pastikan semua informasi yang Anda berikan akurat dan jelas agar admin dapat menindaklanjuti dengan cepat.</p>
    </div>
  </div>
</div>
@endsection