@extends('layouts.app')

@section('title', 'Daftar Aspirasi')
@section('page-title', 'Daftar Aspirasi')

@section('breadcrumb')
  <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">Dashboard</a></li>
  <li class="breadcrumb-item active">Daftar Aspirasi</li>
@endsection

@section('content')
@if(session('success'))
  <div class="alert alert-success alert-dismissible">
    <button type="button" class="close" data-dismiss="alert">&times;</button>
    <i class="icon fas fa-check"></i> {{ session('success') }}
  </div>
@endif

<!-- Filter Card -->
<div class="card card-primary card-outline collapsed-card">
  <div class="card-header">
    <h3 class="card-title"><i class="fas fa-filter"></i> Filter Aspirasi</h3>
    <div class="card-tools">
      <button type="button" class="btn btn-tool" data-card-widget="collapse">
        <i class="fas fa-plus"></i>
      </button>
    </div>
  </div>
  <form method="GET" action="{{ route('admin.aspirasi.index') }}">
    <div class="card-body">
      <div class="row">
        <!-- Tanggal -->
        <div class="col-md-3">
          <div class="form-group">
            <label for="filter_tanggal">
              <i class="fas fa-calendar-day"></i> Tanggal
            </label>
            <input type="date" 
                   id="filter_tanggal"
                   name="tanggal" 
                   class="form-control" 
                   value="{{ request('tanggal') }}">
          </div>
        </div>

        <!-- Bulan -->
        <div class="col-md-3">
          <div class="form-group">
            <label for="filter_bulan">
              <i class="fas fa-calendar-alt"></i> Bulan
            </label>
            <select name="bulan" id="filter_bulan" class="form-control">
              <option value="">Semua Bulan</option>
              @for($i = 1; $i <= 12; $i++)
                <option value="{{ $i }}" {{ request('bulan') == $i ? 'selected' : '' }}>
                  {{ DateTime::createFromFormat('!m', $i)->format('F') }}
                </option>
              @endfor
            </select>
          </div>
        </div>

        <!-- Tahun -->
        <div class="col-md-2">
          <div class="form-group">
            <label for="filter_tahun">
              <i class="fas fa-calendar"></i> Tahun
            </label>
            <select name="tahun" id="filter_tahun" class="form-control">
              <option value="">Semua</option>
              @for($y = date('Y'); $y >= date('Y') - 3; $y--)
                <option value="{{ $y }}" {{ request('tahun') == $y ? 'selected' : '' }}>
                  {{ $y }}
                </option>
              @endfor
            </select>
          </div>
        </div>

        <!-- Status -->
        <div class="col-md-4">
          <div class="form-group">
            <label for="filter_status">
              <i class="fas fa-info-circle"></i> Status
            </label>
            <select name="status" id="filter_status" class="form-control">
              <option value="">Semua Status</option>
              <option value="menunggu" {{ request('status') == 'menunggu' ? 'selected' : '' }}>
                Menunggu
              </option>
              <option value="proses" {{ request('status') == 'proses' ? 'selected' : '' }}>
                Proses
              </option>
              <option value="selesai" {{ request('status') == 'selesai' ? 'selected' : '' }}>
                Selesai
              </option>
            </select>
          </div>
        </div>

        <!-- Siswa -->
        <div class="col-md-4">
          <div class="form-group">
            <label for="filter_siswa">
              <i class="fas fa-user"></i> Siswa
            </label>
            <select name="siswa" id="filter_siswa" class="form-control select2">
              <option value="">Semua Siswa</option>
              @foreach($siswas as $siswa)
                <option value="{{ $siswa->id }}" {{ request('siswa') == $siswa->id ? 'selected' : '' }}>
                  {{ $siswa->nama }} ({{ $siswa->nisn }})
                </option>
              @endforeach
            </select>
          </div>
        </div>

        <!-- Kategori -->
        <div class="col-md-4">
          <div class="form-group">
            <label for="filter_kategori">
              <i class="fas fa-tag"></i> Kategori
            </label>
            <select name="kategori" id="filter_kategori" class="form-control">
              <option value="">Semua Kategori</option>
              @foreach($kategoris as $kategori)
                <option value="{{ $kategori->id }}" {{ request('kategori') == $kategori->id ? 'selected' : '' }}>
                  {{ $kategori->ket_kategoris }}
                </option>
              @endforeach
            </select>
          </div>
        </div>

        <!-- Button Actions -->
        <div class="col-md-4">
          <div class="form-group">
            <label>&nbsp;</label>
            <div>
              <button type="submit" class="btn btn-primary">
                <i class="fas fa-search"></i> Filter
              </button>
              <a href="{{ route('admin.aspirasi.index') }}" class="btn btn-secondary">
                <i class="fas fa-redo"></i> Reset
              </a>
            </div>
          </div>
        </div>
      </div>
    </div>
  </form>
</div>

<!-- Summary Stats -->
<div class="row">
  <div class="col-lg-3 col-6">
    <div class="small-box bg-info">
      <div class="inner">
        <h3>{{ $aspirasis->total() }}</h3>
        <p>Total Aspirasi</p>
      </div>
      <div class="icon">
        <i class="fas fa-clipboard-list"></i>
      </div>
    </div>
  </div>
  <div class="col-lg-3 col-6">
    <div class="small-box bg-warning">
      <div class="inner">
        <h3>{{ $aspirasis->where('aspirasi.status', 'menunggu')->count() }}</h3>
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
        <h3>{{ $aspirasis->where('aspirasi.status', 'proses')->count() }}</h3>
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
        <h3>{{ $aspirasis->where('aspirasi.status', 'selesai')->count() }}</h3>
        <p>Selesai</p>
      </div>
      <div class="icon">
        <i class="fas fa-check-circle"></i>
      </div>
    </div>
  </div>
</div>

<!-- List Aspirasi -->
<div class="card">
  <div class="card-header">
    <h3 class="card-title">
      <i class="fas fa-list"></i> Daftar Aspirasi 
      <span class="badge badge-primary">{{ $aspirasis->total() }} total</span>
    </h3>
    <div class="card-tools">
      <button type="button" class="btn btn-tool" data-card-widget="collapse">
        <i class="fas fa-minus"></i>
      </button>
    </div>
  </div>
  <div class="card-body p-0">
    <div class="table-responsive">
      <table class="table table-striped table-hover">
        <thead>
          <tr>
            <th style="width: 80px;">ID</th>
            <th style="width: 110px;">Tanggal</th>
            <th style="width: 120px;">NISN</th>
            <th>Nama Siswa</th>
            <th style="width: 100px;">Kelas</th>
            <th style="width: 130px;">Kategori</th>
            <th>Lokasi</th>
            <th style="width: 100px;">Status</th>
            <th style="width: 100px;" class="text-center">Aksi</th>
          </tr>
        </thead>
        <tbody>
          @forelse($aspirasis as $aspirasi)
            <tr>
              <td>
                <strong>#{{ $aspirasi->id_pelaporan }}</strong>
              </td>
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
              <td>
                <strong>{{ $aspirasi->siswa->nama ?? '-' }}</strong>
              </td>
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
              <td>
                <small>{{ Str::limit($aspirasi->lokasi, 25) }}</small>
              </td>
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
                <span class="text-muted">Tidak ada data aspirasi</span>
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

@push('styles')
<!-- Select2 -->
<link rel="stylesheet" href="{{ asset('plugins/select2/css/select2.min.css') }}">
<link rel="stylesheet" href="{{ asset('plugins/select2-bootstrap4-theme/select2-bootstrap4.min.css') }}">
@endpush

@push('scripts')
<!-- Select2 -->
<script src="{{ asset('plugins/select2/js/select2.full.min.js') }}"></script>
<script>
  $(function () {
    // Initialize Select2
    $('.select2').select2({
      theme: 'bootstrap4',
      placeholder: 'Pilih Siswa',
      allowClear: true
    });
  });
</script>
@endpush