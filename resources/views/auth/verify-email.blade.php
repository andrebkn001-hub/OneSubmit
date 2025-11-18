<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Verifikasi Email - Sistem OneSubmit</title>
    <link rel="icon" type="image/webp" href="{{ asset('images/unri22.webp') }}">
    <link rel="apple-touch-icon" href="{{ asset('images/unri22.webp') }}">
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
</head>
<body class="min-h-screen bg-gradient-to-br from-sky-400 via-sky-500 to-sky-600 flex items-center justify-center p-4" style="background-image: url('{{ asset('images/hero-bg.jpg') }}'); background-size: cover; background-position: center; background-repeat: no-repeat; background-attachment: fixed;">

    <!-- Background Overlay -->
    <div class="fixed inset-0 bg-black/30"></div>
    <div class="fixed inset-0 bg-gradient-to-r from-sky-500/80 via-sky-600/60 to-sky-700/80"></div>

    <!-- Verification Card -->
    <div class="relative bg-white rounded-xl shadow-2xl p-8 w-full max-w-md">
        <!-- Header -->
        <div class="text-center mb-8">
            <div class="flex items-center justify-center mb-4">
                <img src="{{ asset('images/unri.png') }}" alt="Universitas Riau Logo" class="h-12 mr-3">
                <a href="{{ url('/') }}" class="text-2xl font-bold text-gray-900 hover:text-blue-600 transition-colors">OneSubmit</a>
            </div>
            
            <!-- Email Icon -->
            <div class="mx-auto w-20 h-20 bg-gradient-to-br from-blue-500 to-blue-600 rounded-full flex items-center justify-center mb-4 shadow-lg">
                <i class="fas fa-envelope text-white text-3xl"></i>
            </div>
            
            <h2 class="text-2xl font-bold text-gray-900 mb-2">Verifikasi Email Anda</h2>
            <p class="text-sm text-gray-600">Universitas Riau</p>
        </div>

        <!-- Info Message -->
        <div class="bg-blue-50 border-l-4 border-blue-500 p-4 mb-6 rounded-r-lg">
            <div class="flex items-start">
                <i class="fas fa-info-circle text-blue-500 mt-0.5 mr-3"></i>
                <div>
                    <p class="text-sm text-gray-700 leading-relaxed">
                        Terima kasih telah mendaftar! Kami telah mengirimkan link verifikasi ke email <strong>@student.unri.ac.id</strong> Anda. 
                        Silakan cek inbox atau folder spam Anda.
                    </p>
                </div>
            </div>
        </div>

        <!-- Success Message -->
        @if (session('status') == 'verification-link-sent')
            <div class="bg-green-50 border-l-4 border-green-500 p-4 mb-6 rounded-r-lg animate-pulse">
                <div class="flex items-start">
                    <i class="fas fa-check-circle text-green-500 mt-0.5 mr-3"></i>
                    <div>
                        <p class="text-sm text-green-700 font-medium">
                            Link verifikasi baru telah dikirim ke email Anda!
                        </p>
                    </div>
                </div>
            </div>
        @endif

        <!-- Steps -->
        <div class="mb-6">
            <h3 class="text-sm font-semibold text-gray-700 mb-3">Langkah Verifikasi:</h3>
            <div class="space-y-3">
                <div class="flex items-start">
                    <div class="flex-shrink-0 w-6 h-6 bg-blue-100 rounded-full flex items-center justify-center mr-3">
                        <span class="text-xs font-bold text-blue-600">1</span>
                    </div>
                    <p class="text-sm text-gray-600">Buka email dari OneSubmit UNRI</p>
                </div>
                <div class="flex items-start">
                    <div class="flex-shrink-0 w-6 h-6 bg-blue-100 rounded-full flex items-center justify-center mr-3">
                        <span class="text-xs font-bold text-blue-600">2</span>
                    </div>
                    <p class="text-sm text-gray-600">Klik tombol "Verifikasi Email"</p>
                </div>
                <div class="flex items-start">
                    <div class="flex-shrink-0 w-6 h-6 bg-blue-100 rounded-full flex items-center justify-center mr-3">
                        <span class="text-xs font-bold text-blue-600">3</span>
                    </div>
                    <p class="text-sm text-gray-600">Akun Anda akan aktif dan siap digunakan</p>
                </div>
            </div>
        </div>

        <!-- Divider -->
        <div class="relative my-6">
            <div class="absolute inset-0 flex items-center">
                <div class="w-full border-t border-gray-200"></div>
            </div>
            <div class="relative flex justify-center text-xs uppercase">
                <span class="bg-white px-2 text-gray-500">Tidak menerima email?</span>
            </div>
        </div>

        <!-- Actions -->
        <div class="space-y-3">
            <!-- Resend Button -->
            <form method="POST" action="{{ route('verification.send') }}">
                @csrf
                <button type="submit" class="w-full bg-gradient-to-r from-blue-500 to-blue-600 text-white font-semibold py-3 px-4 rounded-lg hover:from-blue-600 hover:to-blue-700 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-offset-2 transition-all duration-200 shadow-md hover:shadow-lg flex items-center justify-center">
                    <i class="fas fa-paper-plane mr-2"></i>
                    Kirim Ulang Email Verifikasi
                </button>
            </form>

            <!-- Logout Button -->
            <form method="POST" action="{{ route('logout') }}">
                @csrf
                <button type="submit" class="w-full bg-gray-100 text-gray-700 font-medium py-3 px-4 rounded-lg hover:bg-gray-200 focus:outline-none focus:ring-2 focus:ring-gray-400 focus:ring-offset-2 transition-all duration-200 flex items-center justify-center">
                    <i class="fas fa-sign-out-alt mr-2"></i>
                    Keluar
                </button>
            </form>
        </div>

        <!-- Help Text -->
        <div class="mt-6 text-center">
            <p class="text-xs text-gray-500">
                <i class="fas fa-question-circle mr-1"></i>
                Butuh bantuan? Hubungi 
                <a href="mailto:support@unri.ac.id" class="text-blue-600 hover:text-blue-700 font-medium">support@unri.ac.id</a>
            </p>
        </div>
    </div>

    <!-- Footer -->
    <div class="fixed bottom-4 left-0 right-0 text-center">
        <p class="text-white text-sm font-medium drop-shadow-lg">
            © {{ date('Y') }} Universitas Riau. All rights reserved.
        </p>
    </div>

</body>
</html>
