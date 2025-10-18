<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login | OneSubmit</title>
    @vite(['resources/js/app.js'])
</head>
<body class="bg-light d-flex justify-content-center align-items-center vh-100">
    <div class="card shadow-lg p-4" style="width: 400px;">
        <div class="text-center mb-4">
            <h3 class="fw-bold text-primary">OneSubmit</h3>
            <p class="text-muted mb-0">Masuk ke akun Anda</p>
        </div>

        @if (session('status'))
            <div class="alert alert-success">{{ session('status') }}</div>
        @endif

        <form method="POST" action="{{ route('login') }}">
            @csrf

            <div class="mb-3">
                <label for="email" class="form-label">Alamat Email</label>
                <input id="email" type="email" class="form-control @error('email') is-invalid @enderror"
                       name="email" value="{{ old('email') }}" required autofocus>
                @error('email')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>

            <div class="mb-3">
                <label for="password" class="form-label">Kata Sandi</label>
                <input id="password" type="password" class="form-control @error('password') is-invalid @enderror"
                       name="password" required>
                @error('password')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>

            <div class="d-flex justify-content-between align-items-center mb-3">
                <div class="form-check">
                    <input class="form-check-input" type="checkbox" name="remember" id="remember">
                    <label class="form-check-label" for="remember">Ingat Saya</label>
                </div>
                @if (Route::has('password.request'))
                    <a class="text-decoration-none small" href="{{ route('password.request') }}">
                        Lupa Password?
                    </a>
                @endif
            </div>

            <button type="submit" class="btn btn-primary w-100">Login</button>

            <div class="text-center mt-3">
                <span class="text-muted">Belum punya akun?</span>
                <a href="{{ route('register') }}" class="text-decoration-none">Daftar</a>
            </div>
        </form>
    </div>
</body>
</html>
