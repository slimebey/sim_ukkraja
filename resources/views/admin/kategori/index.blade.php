@extends('layouts.app')

@section('title', 'Kelola Kategori')
@section('page-title', 'Kelola Kategori')

@section('breadcrumb')
  <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">Dashboard</a></li>
  <li class="breadcrumb-item active">Kelola Kategori</li>
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

<div class="row">
  <div class="col-12">
    <div class="card">
      <div class="card-header">
        <h3 class="card-title">Daftar Kategori</h3>
        <div class="card-tools">
          <a href="{{ route('admin.kategori.create') }}" class="btn btn-primary btn-sm">
            <i class="fas fa-plus"></i> Tambah Kategori
          </a>
        </div>
      </div>
      <div class="card-body p-0">
        <table class="table table-striped table-hover">
          <thead>
            <tr>
              <th width="80">No</th>
              <th>Nama Kategori</th>
              <th width="150">Jumlah Digunakan</th>
              <th width="150">Aksi</th>
            </tr>
          </thead>
          <tbody>
            @forelse($kategoris as $index => $kategori)
              <tr>
                <td>{{ $kategoris->firstItem() + $index }}</td>
                <td>{{ $kategori->ket_kategoris }}</td>
                <td>
                  <span class="badge badge-info">
                    {{ $kategori->input_aspirasis_count }} Aspirasi
                  </span>
                </td>
                <td>
                  <a href="{{ route('admin.kategori.edit', $kategori->id) }}" 
                     class="btn btn-sm btn-warning" 
                     title="Edit">
                    <i class="fas fa-edit"></i>
                  </a>
                  <form action="{{ route('admin.kategori.destroy', $kategori->id) }}" 
                        method="POST" 
                        class="d-inline"
                        onsubmit="return confirm('Yakin ingin menghapus kategori ini?')">
                    @csrf
                    @method('DELETE')
                    <button type="submit" 
                            class="btn btn-sm btn-danger" 
                            title="Hapus"
                            {{ $kategori->input_aspirasis_count > 0 ? 'disabled' : '' }}>
                      <i class="fas fa-trash"></i>
                    </button>
                  </form>
                </td>
              </tr>
            @empty
              <tr>
                <td colspan="4" class="text-center py-4">
                  <i class="fas fa-inbox fa-3x text-muted mb-3"></i><br>
                  Belum ada kategori
                </td>
              </tr>
            @endforelse
          </tbody>
        </table>
      </div>
      @if($kategoris->hasPages())
        <div class="card-footer clearfix">
          {{ $kategoris->links() }}
        </div>
      @endif
    </div>
  </div>
</div>

<div class="row">
  <div class="col-12">
    <div class="callout callout-info">
      <h5><i class="fas fa-info-circle"></i> Informasi:</h5>
      <p class="mb-0">Kategori yang masih digunakan pada aspirasi tidak dapat dihapus. Silakan hapus aspirasi terkait terlebih dahulu.</p>
    </div>
  </div>
</div>
@endsection