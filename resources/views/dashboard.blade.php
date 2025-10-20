<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Dashboard') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    <h1 class="text-2xl font-bold mb-4">Selamat datang, {{ Auth::user()->name }}</h1>

                    <p class="mb-4">{{ __("You're logged in!") }}</p>

                    <!-- Tombol menuju halaman pengajuan -->
                    <a href="{{ route('pengajuan.index') }}" 
                       class="inline-block bg-blue-600 text-white px-4 py-2 rounded-lg hover:bg-blue-700 transition">
                        Ajukan Proposal / Lihat Status
                    </a>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>