<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Login - Sistem Pengaduan Sekolah</title>

  <!-- Google Font: Source Sans Pro -->
  <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700&display=fallback">
  <!-- Font Awesome -->
  <link rel="stylesheet" href="{{ asset('plugins/fontawesome-free/css/all.min.css') }}">
  <!-- icheck bootstrap -->
  <link rel="stylesheet" href="{{ asset('plugins/icheck-bootstrap/icheck-bootstrap.min.css') }}">
  <!-- Theme style -->
  <link rel="stylesheet" href="{{ asset('dist/css/adminlte.min.css') }}">
</head>
<body class="hold-transition login-page">
<div class="login-box">
  <div class="card card-outline card-primary">
    <div class="card-header text-center">
      <a href="" class="h1"><b>Pengaduan</b> Sekolah</a>
    </div>
    <div class="card-body">
      <p class="login-box-msg">Silakan login untuk melanjutkan</p>

      @if(session('success'))
        <div class="alert alert-success alert-dismissible">
          <button type="button" class="close" data-dismiss="alert">&times;</button>
          {{ session('success') }}
        </div>
      @endif

      @if(session('error'))
        <div class="alert alert-danger alert-dismissible">
          <button type="button" class="close" data-dismiss="alert">&times;</button>
          {{ session('error') }}
        </div>
      @endif

      @if($errors->any())
        <div class="alert alert-danger alert-dismissible">
          <button type="button" class="close" data-dismiss="alert">&times;</button>
          <ul class="mb-0 pl-4">
            @foreach($errors->all() as $error)
              <li>{{ $error }}</li>
            @endforeach
          </ul>
        </div>
      @endif

      <form method="POST" action="{{ route('login') }}">
        @csrf

        <div class="form-group">
          <label for="login_as">Login Sebagai</label>
          <select id="login_as" name="login_as" class="form-control @error('login_as') is-invalid @enderror" required>
            <option value="">-- Pilih --</option>
            <option value="admin" {{ old('login_as') == 'admin' ? 'selected' : '' }}>Admin</option>
            <option value="siswa" {{ old('login_as') == 'siswa' ? 'selected' : '' }}>Siswa</option>
          </select>
          @error('login_as')
            <span class="invalid-feedback">{{ $message }}</span>
          @enderror
        </div>

        <div class="input-group mb-3">
          <input type="text" 
                 name="username" 
                 class="form-control @error('username') is-invalid @enderror" 
                 placeholder="Username / NISN"
                 value="{{ old('username') }}"
                 required autofocus>
          <div class="input-group-append">
            <div class="input-group-text">
              <span class="fas fa-user"></span>
            </div>
          </div>
          @error('username')
            <span class="invalid-feedback">{{ $message }}</span>
          @enderror
        </div>

        <div class="input-group mb-3">
          <input type="password" 
                 name="password" 
                 class="form-control @error('password') is-invalid @enderror" 
                 placeholder="Password"
                 required>
          <div class="input-group-append">
            <div class="input-group-text">
              <span class="fas fa-lock"></span>
            </div>
          </div>
          @error('password')
            <span class="invalid-feedback">{{ $message }}</span>
          @enderror
        </div>

        <div class="row">
          <div class="col-8">
            <div class="icheck-primary">
              <input type="checkbox" id="remember" name="remember">
              <label for="remember">
                Ingat Saya
              </label>
            </div>
          </div>
          <div class="col-4">
            <button type="submit" class="btn btn-primary btn-block">Login</button>
          </div>
        </div>
      </form>

      <div class="mt-3">
        <p class="mb-1 text-center text-muted">
          <small>
            <i class="fas fa-info-circle"></i> Pilih role sesuai dengan akun Anda
          </small>
        </p>
      </div>
    </div>
  </div>
</div>

<!-- jQuery -->
<script src="{{ asset('plugins/jquery/jquery.min.js') }}"></script>
<!-- Bootstrap 4 -->
<script src="{{ asset('plugins/bootstrap/js/bootstrap.bundle.min.js') }}"></script>
<!-- AdminLTE App -->
<script src="{{ asset('dist/js/adminlte.min.js') }}"></script>
</body>
</html>