<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    {{-- Menggunakan nama aplikasi dari file .env --}}
    <title>{{ config('app.name', 'Laravel') }}</title>

    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />

    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>

<body class="font-sans antialiased">
    <div class="min-h-screen bg-gray-100 dark:bg-gray-900">
        {{-- Memanggil file navigasi yang akan kita ubah selanjutnya --}}
        @include('layouts.navigation')

        @if (isset($header))
            <header class="bg-white dark:bg-gray-800 shadow">
                <div class="max-w-7xl mx-auto py-6 px-4 sm:px-6 lg:px-8">
                    {{ $header }}
                </div>
            </header>
        @endif

        <main>
            {{ $slot }}
        </main>
    </div>

    {{-- Script untuk SweetAlert2 (jika Anda menggunakannya) --}}
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11">
        document.addEventListener('alpine:init', () => {
            Alpine.data('themeSwitcher', () => ({
                theme: 'system',
                init() {
                    this.theme = localStorage.getItem('theme') || 'system';
                    this.applyTheme(this.theme); // Terapkan tema saat halaman dimuat

                    // Pantau perubahan tema dari sistem operasi
                    window.matchMedia('(prefers-color-scheme: dark)').addEventListener('change', e => {
                        if (this.theme === 'system') {
                            this.applyTheme('system');
                        }
                    });
                },
                applyTheme(theme) {
                    this.theme = theme;
                    if (theme === 'system') {
                        localStorage.removeItem('theme');
                        if (window.matchMedia('(prefers-color-scheme: dark)').matches) {
                            document.documentElement.classList.add('dark');
                        } else {
                            document.documentElement.classList.remove('dark');
                        }
                    } else if (theme === 'dark') {
                        localStorage.setItem('theme', 'dark');
                        document.documentElement.classList.add('dark');
                    } else {
                        localStorage.setItem('theme', 'light');
                        document.documentElement.classList.remove('dark');
                    }
                }
            }))
        })
    </script>
    @stack('scripts')
</body>

</html>
