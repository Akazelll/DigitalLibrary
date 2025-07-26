<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Dashboard') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg mb-6">
                <div class="p-6 text-gray-900 dark:text-gray-100">
                    <h3 class="text-lg font-medium">{{ $greeting }}, {{ Auth::user()->name }}!</h3>
                    <p class="mt-1 text-sm text-gray-600 dark:text-gray-400">
                        @if (Auth::user()->role == 'admin')
                            Berikut adalah ringkasan data dari aplikasi perpustakaan Anda.
                        @else
                            Selamat datang di DigiPustaka. Cari dan pinjam buku favoritmu!
                        @endif
                    </p>
                </div>
            </div>

            @if (Auth::user()->role == 'admin')
                {{-- Tampilan Admin --}}
            @else 
                {{-- Tampilan User --}}
            @endif

        </div>
    </div>
</x-app-layout>