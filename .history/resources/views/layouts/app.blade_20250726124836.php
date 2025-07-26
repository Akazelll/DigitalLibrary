<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Laravel') }}</title>

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />

    <!-- Scripts -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])

    {{-- ==================================================================== --}}
    {{-- === SCRIPT TEMA DITEMPATKAN DI HEAD UNTUK MENCEGAH KEDIPAN HALAMAN === --}}
    {{-- ==================================================================== --}}
    <script>
        // Logika ini dijalankan sebelum halaman dirender.
        // Ia memeriksa pilihan tema dari localStorage atau dari pengaturan sistem operasi.
        if (localStorage.theme === 'dark' || (!('theme' in localStorage) && window.matchMedia(
                '(prefers-color-scheme: dark)').matches)) {
            document.documentElement.classList.add('dark')
        } else {
            document.documentElement.classList.remove('dark')
        }
    </script>
</head>

<body class="font-sans antialiased">
    <div class="min-h-screen bg-gray-100 dark:bg-gray-900">
        @include('layouts.navigation')

        <!-- Page Heading -->
        @if (isset($header))
            <header class="bg-white dark:bg-gray-800 shadow">
                <div class="max-w-7xl mx-auto py-6 px-4 sm:px-6 lg:px-8">
                    {{ $header }}
                </div>
            </header>
        @endif

        <!-- Page Content -->
        <main>
            {{ $slot }}
        </main>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    @stack('scripts')

    {{-- ==================================================================== --}}
    {{-- === LOGIKA ALPINE.JS UNTUK INTERAKTIVITAS TOMBOL === --}}
    {{-- ==================================================================== --}}
    <script>
        document.addEventListener('alpine:init', () => {
            Alpine.data('themeSwitcher', () => ({
                // Baca tema dari localStorage, jika tidak ada, default ke 'system'
                theme: localStorage.getItem('theme') || 'system',

                // Fungsi yang dipanggil oleh tombol di dropdown
                applyTheme(newTheme) {
                    this.theme = newTheme;
                    // Simpan pilihan baru ke localStorage
                    localStorage.setItem('theme', newTheme);

                    // Terapkan tema ke halaman
                    if (newTheme === 'dark' || (newTheme === 'system' && window.matchMedia(
                            '(prefers-color-scheme: dark)').matches)) {
                        document.documentElement.classList.add('dark');
                    } else {
                        document.documentElement.classList.remove('dark');
                    }
                }
            }));
        });
    </script>
</body>

</html>
