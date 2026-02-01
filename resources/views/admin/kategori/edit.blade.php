@extends('layouts.app')

@section('title', 'Edit Kategori')
@section('page-title', 'Edit Kategori')

@section('breadcrumb')
  <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">Dashboard</a></li>
  <li class="breadcrumb-item"><a href="{{ route('admin.kategori.index') }}">Kelola Kategori</a></li>
  <li class="breadcrumb-item active">Edit</li>
@endsection

@section('content')
<div class="row">
  <div class="col-md-6">
    <div class="card card-warning">
      <div class="card-header">
        <h3 class="card-title">Form Edit Kategori</h3>
      </div>
      
      <form method="POST" action="{{ route('admin.kategori.update', $kategori->id) }}">
        @csrf
        @method('PUT')
        <div class="card-body">
          <div class="form-group">
            <label for="ket_kategoris">Nama Kategori <span class="text-danger">*</span></label>
            <input type="text" 
                   name="ket_kategoris" 
                   id="ket_kategoris" 
                   class="form-control @error('ket_kategoris') is-invalid @enderror" 
                   value="{{ old('ket_kategoris', $kategori->ket_kategoris) }}"
                   placeholder="Contoh: Ruang Kelas, Toilet, Listrik"
                   required
                   maxlength="30">
            @error('ket_kategoris')
              <span class="invalid-feedback">{{ $message }}</span>
            @enderror
            <small class="form-text text-muted">Maksimal 30 karakter</small>
          </div>
        </div>

        <div class="card-footer">
          <button type="submit" class="btn btn-warning">
            <i class="fas fa-save"></i> Update
          </button>
          <a href="{{ route('admin.kategori.index') }}" class="btn btn-secondary">
            <i class="fas fa-times"></i> Batal
          </a>
        </div>
      </form>
    </div>
  </div>

  <div class="col-md-6">
    <div class="card card-warning">
      <div class="card-header">
        <h3 class="card-title"><i class="fas fa-exclamation-triangle"></i> Perhatian</h3>
      </div>
      <div class="card-body">
        <p>Mengubah nama kategori akan mempengaruhi:</p>
        <ul class="pl-3">
          <li class="mb-2">Semua aspirasi yang menggunakan kategori ini</li>
          <li class="mb-2">Tampilan di form pengaduan siswa</li>
          <li>Laporan dan statistik</li>
        </ul>
        <p class="mb-0 text-danger"><strong>Pastikan nama baru sudah sesuai!</strong></p>
      </div>
    </div>
  </div>
</div>
@endsection