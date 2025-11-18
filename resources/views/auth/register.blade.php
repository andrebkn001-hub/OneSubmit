<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Register - Sistem OneSubmit</title>
    <link rel="icon" type="image/webp" href="{{ asset('images/unri22.webp') }}">
    <link rel="apple-touch-icon" href="{{ asset('images/unri22.webp') }}">
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="min-h-screen bg-gradient-to-br from-sky-400 via-sky-500 to-sky-600 flex items-center justify-center p-4" style="background-image: url('{{ asset('images/hero-bg.jpg') }}'); background-size: cover; background-position: center; background-repeat: no-repeat; background-attachment: fixed;">

    <!-- Background Overlay -->
    <div class="fixed inset-0 bg-black/30"></div>
    <div class="fixed inset-0 bg-gradient-to-r from-sky-500/80 via-sky-600/60 to-sky-700/80"></div>

    <!-- Registration Card -->
    <div class="relative bg-white rounded-xl shadow-2xl p-8 w-full max-w-md">
        <!-- Header -->
        <div class="text-center mb-8">
            <div class="flex items-center justify-center mb-4">
                <img src="{{ asset('images/unri.png') }}" alt="Universitas Riau Logo" class="h-12 mr-3">
                <a href="{{ url('/') }}" class="text-2xl font-bold text-gray-900 hover:text-blue-600 transition-colors">OneSubmit</a>
            </div>
            <h2 class="text-lg font-semibold text-gray-700">Buat Akun Baru</h2>
            <p class="text-sm text-gray-600 mt-1">Universitas Riau</p>
        </div>

        <!-- Form -->
        <form method="POST" action="{{ route('register') }}" class="space-y-6">
            @csrf

            <!-- Name Field -->
            <div>
                <label for="name" class="block text-sm font-medium text-gray-700 mb-2">
                    Nama Lengkap
                </label>
                <input id="name" type="text"
                       class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition duration-200 @error('name') border-red-500 @enderror"
                       name="name" value="{{ old('name') }}" required autofocus placeholder="Masukkan nama lengkap">
                @error('name')
                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                @enderror
            </div>

            <!-- NIM Field -->
            <div>
                <label for="nim" class="block text-sm font-medium text-gray-700 mb-2">
                    NIM
                </label>
                <input id="nim" type="text"
                       class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition duration-200 @error('nim') border-red-500 @enderror"
                       name="nim" value="{{ old('nim') }}" required placeholder="Masukkan NIM">
                @error('nim')
                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                @enderror
            </div>

            <!-- Email Field -->
            <div>
                <label for="email" class="block text-sm font-medium text-gray-700 mb-2">
                    Alamat Email UNRI
                </label>
                <input id="email" type="email"
                       class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition duration-200 @error('email') border-red-500 @enderror"
                       name="email" value="{{ old('email') }}" required placeholder="contoh: nama@student.unri.ac.id">
                @error('email')
                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                @enderror
            </div>

            <!-- Password Field -->
            <div>
                <label for="password" class="block text-sm font-medium text-gray-700 mb-2">
                    Kata Sandi
                </label>
                <input id="password" type="password"
                       class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition duration-200 @error('password') border-red-500 @enderror"
                       name="password" required placeholder="Masukkan kata sandi">
                @error('password')
                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                @enderror
            </div>

            <!-- Password Confirmation Field -->
            <div>
                <label for="password_confirmation" class="block text-sm font-medium text-gray-700 mb-2">
                    Konfirmasi Kata Sandi
                </label>
                <input id="password_confirmation" type="password"
                       class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition duration-200"
                       name="password_confirmation" required placeholder="Konfirmasi kata sandi">
            </div>

            <!-- Submit Button -->
            <button type="submit"
                    class="w-full bg-blue-600 hover:bg-blue-700 text-white font-semibold py-3 px-4 rounded-lg transition duration-300 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-offset-2">
                Daftar
            </button>
        </form>

        <!-- Login Link -->
        <div class="text-center mt-6">
            <p class="text-gray-600">
                Sudah punya akun?
                <a href="{{ route('login') }}" class="text-blue-600 hover:text-blue-800 font-medium transition duration-200">
                    Login
                </a>
            </p>
        </div>
    </div>
</body>
</html>
