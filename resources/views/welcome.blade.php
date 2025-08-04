<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" class="scroll-smooth">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>DigiPustaka - Perpustakaan Digital Modern</title>
    <link rel="icon" href="{{ asset('favico.svg?v=1.1') }}" type="image/svg+xml">

    {{-- Fonts --}}
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:400,600&display=swap" rel="stylesheet" />

    {{-- Vite Assets --}}
    @vite(['resources/css/app.css', 'resources/js/app.js'])

    {{-- CSS Kustom untuk Animasi --}}
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

<body class="font-sans antialiased">
    <div class="bg-surface">
        {{-- Header / Navigasi --}}
        <header class="absolute inset-x-0 top-0 z-50">
            <nav class="flex items-center justify-between p-6 lg:px-8" aria-label="Global">
                <div class="flex lg:flex-1">
                    <a href="/" class="-m-1.5 p-1.5 flex items-center gap-2">
                        <svg class="h-8 w-auto text-primary" xmlns="http://www.w3.org/2000/svg" fill="none"
                            viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round"
                                d="M12 6.042A8.967 8.967 0 0 0 6 3.75c-1.052 0-2.062.18-3 .512v14.25A8.987 8.987 0 0 1 6 18c2.305 0 4.408.867 6 2.292m0-14.25a8.966 8.966 0 0 1 6-2.292c1.052 0 2.062.18 3 .512v14.25A8.987 8.987 0 0 0 18 18a8.967 8.967 0 0 0-6 2.292m0-14.25v14.25" />
                        </svg>
                        <span class="font-semibold text-xl text-text-main">DigiPustaka</span>
                    </a>
                </div>
                <div class="hidden lg:flex lg:flex-1 lg:justify-end lg:gap-x-6">
                    @auth
                        <a href="{{ url('/dashboard') }}"
                            class="rounded-md px-3.5 py-2.5 text-sm font-semibold text-text-main shadow-sm ring-1 ring-inset ring-gray-200 hover:bg-highlight transition-colors">Dashboard</a>
                    @else
                        <a href="{{ route('login') }}"
                            class="text-sm font-semibold leading-6 text-text-subtle hover:text-text-main transition-colors">Log
                            in <span aria-hidden="true">&rarr;</span></a>
                        @if (Route::has('register'))
                            <a href="{{ route('register') }}"
                                class="rounded-md bg-primary px-3.5 py-2.5 text-sm font-semibold text-white shadow-sm hover:bg-opacity-90 transition-all hover:scale-105">Register</a>
                        @endif
                    @endauth
                </div>
            </nav>
        </header>

        <main>
            {{-- Hero Section --}}
            <div class="relative isolate px-6 pt-14 lg:px-8">
                <div class="absolute inset-x-0 -top-40 -z-10 transform-gpu overflow-hidden blur-3xl sm:-top-80"
                    aria-hidden="true">
                    <div class="relative left-[calc(50%-11rem)] aspect-[1155/678] w-[36.125rem] -translate-x-1/2 rotate-[30deg] bg-gradient-to-tr from-primary to-[#ff80b5] opacity-20 sm:left-[calc(50%-30rem)] sm:w-[72.1875rem]"
                        style="clip-path: polygon(74.1% 44.1%, 100% 61.6%, 97.5% 26.9%, 85.5% 0.1%, 80.7% 2%, 72.5% 32.5%, 60.2% 62.4%, 52.4% 68.1%, 47.5% 58.3%, 45.2% 34.5%, 27.5% 76.7%, 0.1% 64.9%, 17.9% 100%, 27.6% 76.8%, 76.1% 97.7%, 74.1% 44.1%)">
                    </div>
                </div>
                <div class="mx-auto max-w-2xl py-32 sm:py-48 lg:py-56">
                    <div class="text-center">
                        {{-- Animasi Fade-in dengan delay berurutan --}}
                        <h1 class="text-4xl font-bold tracking-tight text-text-main sm:text-6xl animate-fadeIn"
                            style="animation-delay: 200ms;">Gerbang Menuju Dunia Pengetahuan</h1>
                        <p class="mt-6 text-lg leading-8 text-text-subtle animate-fadeIn"
                            style="animation-delay: 400ms;">Pinjam dan baca ribuan koleksi buku
                            digital kami dengan mudah, di mana saja dan kapan saja.</p>
                        <div class="mt-10 flex items-center justify-center gap-x-6 animate-fadeIn"
                            style="animation-delay: 600ms;">
                            <a href="{{ route('register') }}"
                                class="rounded-md bg-primary px-3.5 py-2.5 text-sm font-semibold text-white shadow-sm hover:bg-opacity-90 transition-transform hover:scale-105">Mulai
                                Sekarang</a>
                            <a href="{{ route('login') }}"
                                class="text-sm font-semibold leading-6 text-text-subtle hover:text-text-main">Log In
                                <span aria-hidden="true">→</span></a>
                        </div>
                    </div>
                </div>
            </div>

            {{-- Fitur Section --}}
            <div class="bg-base py-24 sm:py-32">
                <div class="mx-auto max-w-7xl px-6 lg:px-8">
                    <div class="mx-auto max-w-2xl lg:text-center">
                        <h2 class="text-base font-semibold leading-7 text-primary">Semua Jadi Mudah</h2>
                        <p class="mt-2 text-3xl font-bold tracking-tight text-text-main sm:text-4xl">
                            Fitur Unggulan Kami</p>
                        <p class="mt-6 text-lg leading-8 text-text-subtle">Aplikasi perpustakaan digital
                            ini dirancang untuk memberikan kemudahan dalam mengelola dan mengakses koleksi buku Anda.
                        </p>
                    </div>
                    <div class="mx-auto mt-16 max-w-2xl sm:mt-20 lg:mt-24 lg:max-w-4xl">
                        <dl class="grid max-w-xl grid-cols-1 gap-x-8 gap-y-10 lg:max-w-none lg:grid-cols-2 lg:gap-y-16">

                            {{-- Kartu Fitur dengan Animasi Hover --}}
                            <div class="relative pl-16 transition-transform duration-300 hover:scale-105">
                                <dt class="text-base font-semibold leading-7 text-text-main">
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
                                <dd class="mt-2 text-base leading-7 text-text-subtle">Kelola daftar buku dan penerbit
                                    dengan mudah melalui antarmuka CRUD yang intuitif.</dd>
                            </div>

                            <div class="relative pl-16 transition-transform duration-300 hover:scale-105">
                                <dt class="text-base font-semibold leading-7 text-text-main">
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
                                <dd class="mt-2 text-base leading-7 text-text-subtle">Sistem autentikasi lengkap
                                    memungkinkan admin mengelola pengguna dan pengguna lain untuk mendaftar dan login.
                                </dd>
                            </div>

                            <div class="relative pl-16 transition-transform duration-300 hover:scale-105">
                                <dt class="text-base font-semibold leading-7 text-text-main">
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
                                <dd class="mt-2 text-base leading-7 text-text-subtle">Catat transaksi peminjaman dan
                                    pengembalian buku dengan mudah untuk melacak status setiap koleksi.</dd>
                            </div>

                            <div class="relative pl-16 transition-transform duration-300 hover:scale-105">
                                <dt class="text-base font-semibold leading-7 text-text-main">
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
                                <dd class="mt-2 text-base leading-7 text-text-subtle">Dibangun dengan TailwindCSS,
                                    aplikasi dapat diakses dengan nyaman di berbagai perangkat.</dd>
                            </div>
                        </dl>
                    </div>
                </div>
            </div>
        </main>

        {{-- Footer --}}
        <footer class="bg-surface">
            <div class="mx-auto max-w-7xl overflow-hidden px-6 py-12 lg:px-8">
                <p class="text-center text-xs leading-5 text-text-subtle">&copy; {{ date('Y') }} DigiPustaka. All
                    rights reserved.</p>
            </div>
        </footer>
    </div>
</body>

</html>
