{{-- GUNAKAN STRUKTUR INI --}}
<x-app-layout>
    {{-- Bagian Header Halaman (Opsional, tapi direkomendasikan) --}}
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Data Penerbit') }}
        </h2>
    </x-slot>

    {{-- Bagian Konten Utama Halaman --}}
    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900 dark:text-gray-100">
                    <h1>Isi Halaman Penerbit</h1>
                    {{-- ...tabel dan konten lainnya diletakkan di sini... --}}
                </div>
            </div>
        </div>
    </div>
</x-app-layout>