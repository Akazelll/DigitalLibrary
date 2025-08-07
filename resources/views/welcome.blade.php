<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" class="scroll-smooth">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>DigiPustaka - Perpustakaan Digital Modern</title>
    <link rel="icon" href="{{ asset('favico.svg?v=1.1') }}" type="image/svg+xml">
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:400,600,700&display=swap" rel="stylesheet" />
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <style>
        @keyframes fadeIn {
            from {
                opacity: 0;
                transform: translateY(20px);
            }

            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        .animate-fadeIn {
            animation: fadeIn 1s ease-out forwards;
        }
    </style>
</head>

<body class="font-sans antialiased bg-base dark:bg-dark-base" x-data="themeSwitcher()" x-init="init()">
    <div class="overflow-x-hidden">
        {{-- Header / Navigasi --}}
        <header class="absolute inset-x-0 top-0 z-50">
            <nav class="flex items-center justify-between p-6 lg:px-8 max-w-7xl mx-auto" aria-label="Global">
                <div class="flex lg:flex-1">
                    <a href="/" class="-m-1.5 p-1.5 flex items-center gap-2">
                        <svg class="h-8 w-auto text-primary dark:text-white" xmlns="http://www.w3.org/2000/svg"
                            fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round"
                                d="M12 6.042A8.967 8.967 0 0 0 6 3.75c-1.052 0-2.062.18-3 .512v14.25A8.987 8.987 0 0 1 6 18c2.305 0 4.408.867 6 2.292m0-14.25a8.966 8.966 0 0 1 6-2.292c1.052 0 2.062.18 3 .512v14.25A8.987 8.987 0 0 0 18 18a8.967 8.967 0 0 0-6 2.292m0-14.25v14.25" />
                        </svg>
                        <span class="font-semibold text-xl text-text-main dark:text-white">DigiPustaka</span>
                    </a>
                </div>
                <div class="hidden lg:flex lg:flex-1 lg:justify-end lg:items-center lg:gap-x-6">
                    {{-- Theme Switcher --}}
                    <div x-data="{ open: false }" class="relative">
                        <button @click="open = !open"
                            class="inline-flex items-center justify-center p-2 rounded-md text-text-subtle dark:text-dark-text-subtle hover:text-text-main dark:hover:text-dark-text-main hover:bg-highlight dark:hover:bg-dark-highlight focus:outline-none transition duration-150 ease-in-out">
                            <svg x-show="theme === 'light'" class="h-6 w-6" fill="none" viewBox="0 0 24 24"
                                stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M12 3v1m0 16v1m9-9h-1M4 12H3m15.364 6.364l-.707-.707M6.343 6.343l-.707-.707m12.728 0l-.707.707M6.343 17.657l-.707.707M16 12a4 4 0 11-8 0 4 4 0 018 0z">
                                </path>
                            </svg>
                            <svg x-show="theme === 'dark'" class="h-6 w-6" fill="none" viewBox="0 0 24 24"
                                stroke="currentColor" x-cloak>
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M20.354 15.354A9 9 0 018.646 3.646 9.003 9.003 0 0012 21a9.003 9.003 0 008.354-5.646z">
                                </path>
                            </svg>
                            <svg x-show="theme === 'system'" class="h-6 w-6" fill="none" viewBox="0 0 24 24"
                                stroke="currentColor" x-cloak>
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M9.75 17L9 20l-1 1h8l-1-1-.75-3M3 13h18M5 17h14a2 2 0 002-2V5a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z">
                                </path>
                            </svg>
                        </button>
                        <div x-show="open" @click.away="open = false"
                            class="absolute right-0 mt-2 w-32 bg-surface dark:bg-dark-surface rounded-md shadow-lg py-1 ring-1 ring-black ring-opacity-5"
                            x-cloak>
                            <a href="#" @click.prevent="theme = 'light'"
                                class="block px-4 py-2 text-sm text-text-main dark:text-dark-text-main hover:bg-highlight dark:hover:bg-dark-highlight">Light</a>
                            <a href="#" @click.prevent="theme = 'dark'"
                                class="block px-4 py-2 text-sm text-text-main dark:text-dark-text-main hover:bg-highlight dark:hover:bg-dark-highlight">Dark</a>
                            <a href="#" @click.prevent="theme = 'system'"
                                class="block px-4 py-2 text-sm text-text-main dark:text-dark-text-main hover:bg-highlight dark:hover:bg-dark-highlight">System</a>
                        </div>
                    </div>
                    @auth
                        <a href="{{ url('/dashboard') }}"
                            class="rounded-md px-4 py-2 text-sm font-semibold text-text-main dark:text-dark-text-main shadow-sm ring-1 ring-inset ring-gray-200 dark:ring-dark-primary hover:bg-highlight dark:hover:bg-dark-highlight transition-colors">Dashboard</a>
                    @else
                        <a href="{{ route('login') }}"
                            class="text-sm font-semibold leading-6 text-text-subtle dark:text-dark-text-subtle hover:text-text-main dark:hover:text-dark-text-main transition-colors">Log
                            in</a>
                        @if (Route::has('register'))
                            <a href="{{ route('register') }}"
                                class="rounded-md bg-primary px-4 py-2 text-sm font-semibold text-white shadow-sm hover:bg-opacity-90 transition-all hover:scale-105">Register</a>
                        @endif
                    @endauth
                </div>
            </nav>
        </header>

        <main class="relative isolate min-h-screen flex flex-col items-center justify-center px-6 text-center">
            {{-- Decorative Gradient Wave --}}
            <div class="absolute -bottom-40 -z-10 w-full overflow-hidden">
                <svg viewBox="0 0 1440 320" class="w-full h-auto min-w-[80rem]">
                    <defs>
                        <linearGradient id="waveGradient" x1="0%" y1="0%" x2="100%" y2="0%">
                            <stop offset="0%" stop-color="#D946EF" />
                            <stop offset="50%" stop-color="#6366F1" />
                            <stop offset="100%" stop-color="#06B6D4" />
                        </linearGradient>
                    </defs>
                    <path fill="url(#waveGradient)" fill-opacity="0.2 dark:fill-opacity-0.3"
                        d="M0,192L40,197.3C80,203,160,213,240,186.7C320,160,400,96,480,74.7C560,53,640,75,720,90.7C800,107,880,117,960,101.3C1040,85,1120,43,1200,64C1280,85,1360,171,1400,213.3L1440,256L1440,320L1400,320C1360,320,1280,320,1200,320C1120,320,1040,320,960,320C880,320,800,320,720,320C640,320,560,320,480,320C400,320,320,320,240,320C160,320,80,320,40,320L0,320Z">
                    </path>
                </svg>
            </div>

            <h1 class="text-4xl sm:text-6xl font-bold tracking-tight animate-fadeIn" style="animation-delay: 200ms;">
                <span
                    class="text-transparent bg-clip-text bg-gradient-to-r from-fuchsia-500 via-purple-500 to-cyan-400">
                    Perpustakaan Cerdas.
                </span>
                <br>
                {{-- PERBAIKAN DI SINI --}}
                <span class="text-text-main dark:text-dark-text-main">Pengetahuan Tanpa Batas.</span>
            </h1>
            {{-- PERBAIKAN DI SINI --}}
            <p class="mt-6 text-lg max-w-2xl leading-8 text-text-subtle dark:text-dark-text-subtle animate-fadeIn"
                style="animation-delay: 400ms;">
                Platform kami menggabungkan kecepatan manajemen koleksi dengan keamanan data berbasis AI, memungkinkan
                akses pengetahuan tanpa batas.
            </p>
            <div class="mt-10 flex justify-center gap-x-6 animate-fadeIn" style="animation-delay: 600ms;">
                <a href="{{ route('register') }}"
                    class="rounded-md bg-primary px-5 py-2.5 text-sm font-semibold text-white shadow-sm hover:bg-opacity-90 transition-all hover:scale-105">Mulai
                    Sekarang</a>
                {{-- PERBAIKAN DI SINI --}}
                <a href="{{ route('buku.index') }}"
                    class="rounded-md bg-surface/50 dark:bg-dark-surface/50 px-5 py-2.5 text-sm font-semibold text-text-main dark:text-dark-text-main shadow-sm ring-1 ring-inset ring-gray-300 dark:ring-dark-primary hover:bg-surface/80 dark:hover:bg-dark-surface/80 transition-all hover:scale-105">Jelajahi
                    Koleksi</a>
            </div>
        </main>
        </section>
      

        {{-- Fitur Section --}}
        <section class="bg-base dark:bg-dark-base pt-32 sm:pt-40 pb-24 sm:pb-32">
            <div class="mx-auto max-w-7xl px-6 lg:px-8">
                <div class="mx-auto max-w-2xl lg:text-center animate-fadeIn">
                    <h2 class="text-base font-semibold leading-7 text-primary dark:text-dark-primary">Semua Jadi Mudah
                    </h2>
                    <p
                        class="mt-2 text-3xl font-bold tracking-tight text-text-main dark:text-dark-text-main sm:text-4xl">
                        Fitur Unggulan Kami</p>
                    <p class="mt-6 text-lg leading-8 text-text-subtle dark:text-dark-text-subtle">Aplikasi ini
                        dirancang untuk memberikan kemudahan dalam mengelola dan mengakses koleksi buku Anda.</p>
                </div>
                <div class="mx-auto mt-16 max-w-2xl sm:mt-20 lg:mt-24 lg:max-w-4xl">
                    <dl class="grid max-w-xl grid-cols-1 gap-x-8 gap-y-10 lg:max-w-none lg:grid-cols-2 lg:gap-y-16">

                        <div class="relative pl-16 transition-transform duration-300 hover:scale-105 animate-fadeIn"
                            style="animation-delay: 200ms;">
                            <dt class="text-base font-semibold leading-7 text-text-main dark:text-dark-text-main">
                                <div
                                    class="absolute left-0 top-0 flex h-10 w-10 items-center justify-center rounded-lg bg-primary">
                                    <svg class="h-6 w-6 text-white" fill="none" viewBox="0 0 24 24"
                                        stroke-width="1.5" stroke="currentColor" aria-hidden="true">
                                        <path stroke-linecap="round" stroke-linejoin="round"
                                            d="M12 6.042A8.967 8.967 0 006 3.75c-1.052 0-2.062.18-3 .512v14.25A8.987 8.987 0 016 18c2.305 0 4.408.867 6 2.292m0-14.25v14.25" />
                                    </svg>
                                </div>
                                Manajemen Buku & Penerbit
                            </dt>
                            <dd class="mt-2 text-base leading-7 text-text-subtle dark:text-dark-text-subtle">Kelola
                                daftar buku dan penerbit dengan mudah melalui antarmuka CRUD yang intuitif.</dd>
                        </div>

                        <div class="relative pl-16 transition-transform duration-300 hover:scale-105 animate-fadeIn"
                            style="animation-delay: 300ms;">
                            <dt class="text-base font-semibold leading-7 text-text-main dark:text-dark-text-main">
                                <div
                                    class="absolute left-0 top-0 flex h-10 w-10 items-center justify-center rounded-lg bg-primary">
                                    <svg class="h-6 w-6 text-white" fill="none" viewBox="0 0 24 24"
                                        stroke-width="1.5" stroke="currentColor" aria-hidden="true">
                                        <path stroke-linecap="round" stroke-linejoin="round"
                                            d="M15.75 17.436v-1.472c0-.854-.445-1.663-1.181-2.12-1.44-.9-3.149-.9-4.589 0C9.285 14.301 8.84 15.11 8.84 15.964v1.472M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                                    </svg>
                                </div>
                                Manajemen Pengguna
                            </dt>
                            <dd class="mt-2 text-base leading-7 text-text-subtle dark:text-dark-text-subtle">Sistem
                                autentikasi lengkap memungkinkan admin mengelola pengguna dan pengguna lain untuk
                                mendaftar dan login.</dd>
                        </div>

                        <div class="relative pl-16 transition-transform duration-300 hover:scale-105 animate-fadeIn"
                            style="animation-delay: 400ms;">
                            <dt class="text-base font-semibold leading-7 text-text-main dark:text-dark-text-main">
                                <div
                                    class="absolute left-0 top-0 flex h-10 w-10 items-center justify-center rounded-lg bg-primary">
                                    <svg class="h-6 w-6 text-white" fill="none" viewBox="0 0 24 24"
                                        stroke-width="1.5" stroke="currentColor" aria-hidden="true">
                                        <path stroke-linecap="round" stroke-linejoin="round"
                                            d="M3.75 3v11.25A2.25 2.25 0 006 16.5h12M3.75 3.75h16.5M3.75 12h16.5m-16.5 4.5h16.5" />
                                    </svg>
                                </div>
                                Sistem Peminjaman
                            </dt>
                            <dd class="mt-2 text-base leading-7 text-text-subtle dark:text-dark-text-subtle">Catat
                                transaksi peminjaman dan pengembalian buku dengan mudah untuk melacak status setiap
                                koleksi.</dd>
                        </div>

                        <div class="relative pl-16 transition-transform duration-300 hover:scale-105 animate-fadeIn"
                            style="animation-delay: 500ms;">
                            <dt class="text-base font-semibold leading-7 text-text-main dark:text-dark-text-main">
                                <div
                                    class="absolute left-0 top-0 flex h-10 w-10 items-center justify-center rounded-lg bg-primary">
                                    <svg class="h-6 w-6 text-white" fill="none" viewBox="0 0 24 24"
                                        stroke-width="1.5" stroke="currentColor" aria-hidden="true">
                                        <path stroke-linecap="round" stroke-linejoin="round"
                                            d="M7.5 8.25h9m-9 3H12m-2.25 3h5.25m-5.25-.498l.99-1.103A1.125 1.125 0 015.25 13.5V12m6 0v1.5a1.125 1.125 0 001.697.946l.99-1.103m-5.25 3h5.25" />
                                    </svg>
                                </div>
                                Desain Responsif
                            </dt>
                            <dd class="mt-2 text-base leading-7 text-text-subtle dark:text-dark-text-subtle">Dibangun
                                dengan TailwindCSS, aplikasi dapat diakses dengan nyaman di berbagai perangkat.</dd>
                        </div>
                    </dl>
                </div>
            </div>
        </section>

        {{-- Footer --}}
        <footer class="bg-surface dark:bg-dark-surface border-t border-gray-200 dark:border-dark-primary">
            <div class="mx-auto max-w-7xl overflow-hidden px-6 py-12 lg:px-8">
                <p class="text-center text-xs leading-5 text-text-subtle dark:text-dark-text-subtle">&copy;
                    {{ date('Y') }} DigiPustaka. All rights reserved.</p>
            </div>
        </footer>
    </div>

    {{-- Skrip Theme Switcher --}}
    <script>
        function themeSwitcher() {
            return {
                theme: 'system',
                init() {
                    this.theme = localStorage.getItem('theme') || 'system';
                    this.applyTheme(this.theme);
                    this.$watch('theme', (newTheme) => {
                        localStorage.setItem('theme', newTheme);
                        this.applyTheme(newTheme);
                    });
                    window.matchMedia('(prefers-color-scheme: dark)').addEventListener('change', e => {
                        if (this.theme === 'system') {
                            this.applyTheme('system');
                        }
                    });
                },
                applyTheme(selectedTheme) {
                    if (selectedTheme === 'dark' || (selectedTheme === 'system' && window.matchMedia(
                            '(prefers-color-scheme: dark)').matches)) {
                        document.documentElement.classList.add('dark');
                    } else {
                        document.documentElement.classList.remove('dark');
                    }
                }
            }
        }
    </script>
</body>

</html>
