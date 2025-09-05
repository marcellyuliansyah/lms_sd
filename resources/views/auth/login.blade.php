<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login - LMS SD</title>

    {{-- AdminLTE CSS --}}
    <link rel="stylesheet" href="{{ asset('lte/dist/css/adminlte.min.css') }}">
    {{-- Font Awesome --}}
    <link rel="stylesheet" href="{{ asset('lte/plugins/fontawesome-free/css/all.min.css') }}">
    {{-- Google Font (Opsional) --}}
    <link rel="stylesheet"
          href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700">
</head>
<body class="hold-transition login-page">

<div class="login-box">
    {{-- Logo --}}
    <div class="login-logo">
        <a href="#"><b>LMS</b> SD</a>
    </div>

    {{-- Card --}}
    <div class="card">
        <div class="card-body login-card-body">
            <p class="login-box-msg">Silakan login untuk masuk</p>

            <form method="POST" action="{{ route('login') }}">
                @csrf

                {{-- Email --}}
                <div class="input-group mb-3">
                    <input type="email" name="email" class="form-control" placeholder="Email"
                           value="{{ old('email') }}" required autofocus>
                    <div class="input-group-append">
                        <div class="input-group-text"><span class="fas fa-envelope"></span></div>
                    </div>
                </div>
                @error('email')
                    <small class="text-danger">{{ $message }}</small>
                @enderror

                {{-- Password --}}
                <div class="input-group mb-3">
                    <input type="password" name="password" class="form-control" placeholder="Password" required>
                    <div class="input-group-append">
                        <div class="input-group-text"><span class="fas fa-lock"></span></div>
                    </div>
                </div>
                @error('password')
                    <small class="text-danger">{{ $message }}</small>
                @enderror

                {{-- Remember Me --}}
                <div class="row mb-3">
                    <div class="col-8">
                        <div class="icheck-primary">
                            <input type="checkbox" id="remember" name="remember">
                            <label for="remember">Ingat saya</label>
                        </div>
                    </div>
                </div>

                {{-- Submit --}}
                <div class="row">
                    <div class="col-12">
                        <button type="submit" class="btn btn-primary btn-block">Login</button>
                    </div>
                </div>
            </form>

            {{-- Link tambahan --}}
            <p class="mb-1 mt-3">
                <a href="#">Lupa password?</a>
            </p>
        </div>
    </div>
</div>

{{-- AdminLTE JS --}}
<script src="{{ asset('lte/plugins/jquery/jquery.min.js') }}"></script>
<script src="{{ asset('lte/plugins/bootstrap/js/bootstrap.bundle.min.js') }}"></script>
<script src="{{ asset('lte/dist/js/adminlte.min.js') }}"></script>
</body>
</html>
