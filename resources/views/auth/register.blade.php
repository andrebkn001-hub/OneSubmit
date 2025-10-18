<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Register | OneSubmit</title>
    @vite(['resources/js/app.js'])
</head>
<body class="bg-light d-flex justify-content-center align-items-center vh-100">
    <div class="card shadow-lg p-4" style="width: 450px;">
        <div class="text-center mb-4">
            <h3 class="fw-bold text-primary">OneSubmit</h3>
            <p class="text-muted mb-0">Buat akun baru</p>
        </div>

        <form method="POST" action="{{ route('register') }}">
            @csrf

            <div class="mb-3">
                <label for="name" class="form-label">Nama Lengkap</label>
                <input id="name" type="text" class="form-control @error('name') is-invalid @enderror"
                       name="name" value="{{ old('name') }}" required autofocus>
                @error('name')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>

            <div class="mb-3">
                <label for="email" class="form-label">Alamat Email</label>
                <input id="email" type="email" class="form-control @error('email') is-invalid @enderror"
                       name="email" value="{{ old('email') }}" required>
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

            <div class="mb-3">
                <label for="password_confirmation" class="form-label">Konfirmasi Kata Sandi</label>
                <input id="password_confirmation" type="password" class="form-control"
                       name="password_confirmation" required>
            </div>

            <button type="submit" class="btn btn-success w-100">Daftar</button>

            <div class="text-center mt-3">
                <span class="text-muted">Sudah punya akun?</span>
                <a href="{{ route('login') }}" class="text-decoration-none">Login</a>
            </div>
        </form>
    </div>
</body>
</html>
