@extends('layouts.app')

@section('title', 'Tambah Kategori')
@section('page-title', 'Tambah Kategori Baru')

@section('breadcrumb')
  <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">Dashboard</a></li>
  <li class="breadcrumb-item"><a href="{{ route('admin.kategori.index') }}">Kelola Kategori</a></li>
  <li class="breadcrumb-item active">Tambah</li>
@endsection

@section('content')
<div class="row">
  <div class="col-md-6">
    <div class="card card-primary">
      <div class="card-header">
        <h3 class="card-title">Form Tambah Kategori</h3>
      </div>
      
      <form method="POST" action="{{ route('admin.kategori.store') }}">
        @csrf
        <div class="card-body">
          <div class="form-group">
            <label for="ket_kategoris">Nama Kategori <span class="text-danger">*</span></label>
            <input type="text" 
                   name="ket_kategoris" 
                   id="ket_kategoris" 
                   class="form-control @error('ket_kategoris') is-invalid @enderror" 
                   value="{{ old('ket_kategoris') }}"
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
          <button type="submit" class="btn btn-primary">
            <i class="fas fa-save"></i> Simpan
          </button>
          <a href="{{ route('admin.kategori.index') }}" class="btn btn-secondary">
            <i class="fas fa-times"></i> Batal
          </a>
        </div>
      </form>
    </div>
  </div>

  <div class="col-md-6">
    <div class="card card-info">
      <div class="card-header">
        <h3 class="card-title"><i class="fas fa-lightbulb"></i> Tips</h3>
      </div>
      <div class="card-body">
        <ul class="pl-3">
          <li class="mb-2">Gunakan nama kategori yang singkat dan jelas</li>
          <li class="mb-2">Hindari penggunaan singkatan yang tidak umum</li>
          <li class="mb-2">Kategori akan muncul di form pengaduan siswa</li>
          <li>Maksimal panjang nama adalah 30 karakter</li>
        </ul>
      </div>
    </div>
  </div>
</div>
@endsection