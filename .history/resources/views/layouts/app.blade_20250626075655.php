<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Laravel') }}</title>

    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="bg-gray-100 font-sans antialiased">
    <div x-data="{ open: false }" class="min-h-screen bg-gray-100">
        <header class="bg-white shadow-sm">
            <nav class="container mx-auto px-6 py-4" aria-label="Global">
                <div class="flex items-center justify-between">
                    <div class="flex lg:flex-1">
                        <a href="{{ route('home') }}" class="-m-1.5 p-1.5">
                            <span class="sr-only">Digital Library</span>
                            <img class="h-8 w-auto" src="https://tailwindui.com/img/logos/mark.svg?color=indigo&shade=600" alt="Logo">
                        </a>
                    </div>
                    <div class="flex lg:hidden">
                        <button @click="open = !open" type="button" class="-m-2.5 inline-flex items-center justify-center rounded-md p-2.5 text-gray-700">
                            <span class="sr-only">Open main menu</span>
                            <svg class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M3.75 6.75h16.5M3.75 12h16.5m-16.5 5.25h16.5" />
                            </svg>
                        </button>
                    </div>
                    <div class="hidden lg:flex lg:gap-x-12">
                        <a href="{{ route('home') }}" class="text-sm font-semibold leading-6 text-gray-900">Home</a>
                        @auth
                            @if (Auth::user()->role == 'admin')
                                <a href="{{ route('penerbit.index') }}" class="text-sm font-semibold leading-6 text-gray-900">Penerbit</a> [cite: 95]
                                <a href="{{ route('buku.index') }}" class="text-sm font-semibold leading-6 text-gray-900">Buku</a> [cite: 162]
                                <a href="{{ route('peminjaman.index') }}" class="text-sm font-semibold leading-6 text-gray-900">Peminjaman</a> [cite: 222]
                            @endif
                        @endauth
                    </div>
                    <div class="hidden lg:flex lg:flex-1 lg:justify-end items-center gap-x-6">
                        @guest
                            <a href="{{ route('login') }}" class="text-sm font-semibold leading-6 text-gray-900">Log in <span aria-hidden="true">&rarr;</span></a>
                             @if (Route::has('register'))
                                <a href="{{ route('register') }}" class="rounded-md bg-indigo-600 px-3.5 py-2.5 text-sm font-semibold text-white shadow-sm hover:bg-indigo-500 focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-indigo-600">Register</a>
                            @endif
                        @else
                            <span class="text-sm font-semibold leading-6 text-gray-900">{{ Auth::user()->name }}</span>
                            <a href="{{ route('logout') }}"
                               onclick="event.preventDefault(); document.getElementById('logout-form').submit();"
                               class="rounded-md bg-red-600 px-3.5 py-2.5 text-sm font-semibold text-white shadow-sm hover:bg-red-500">
                                Log out
                            </a>
                            <form id="logout-form" action="{{ route('logout') }}" method="POST" class="hidden">
                                @csrf
                            </form>
                        @endguest
                    </div>
                </div>
                 <div x-show="open" class="lg:hidden" role="dialog" aria-modal="true">
                    <div class="fixed inset-0 z-50"></div>
                    <div class="fixed inset-y-0 right-0 z-50 w-full overflow-y-auto bg-white px-6 py-6 sm:max-w-sm sm:ring-1 sm:ring-gray-900/10">
                        </div>
                </div>
            </nav>
        </header>

        <main class="container mx-auto mt-6 px-6">
            @yield('content')
        </main>
    </div>
</body>
</html>