<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{-- PASTIKAN INI BENAR --}}
            {{ __('Data Buku') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900 dark:text-gray-100">
                    
                    <div class="sm:flex sm:items-center mb-6">
                        <div class="sm:flex-auto">
                            <p class="text-sm text-gray-700 dark:text-gray-300">Daftar semua buku yang tersedia di perpustakaan.</p>
                        </div>
                        <div class="mt-4 sm:ml-16 sm:mt-0 sm:flex-none">
                            {{-- PASTIKAN ROUTE INI BENAR --}}
                            <a href="{{ route('buku.create') }}" class="block rounded-md bg-indigo-600 px-3 py-2 text-center text-sm font-semibold text-white shadow-sm hover:bg-indigo-500">Tambah Data</a>
                        </div>
                    </div>

                    <tbody class="divide-y divide-gray-200 dark:divide-gray-700 bg-white dark:bg-gray-800">
    {{-- Pastikan variabelnya $buku --}}
    @forelse ($buku as $item)
        <tr>
            {{-- ... isi sel tabel ... --}}
        </tr>
    @empty
        {{-- Bagian ini akan tampil jika $buku kosong --}}
        <tr>
            <td colspan="6" class="px-3 py-4 text-sm text-center">Data belum tersedia.</td>
        </tr>
    @endforelse
</tbody>
                    
                </div>
            </div>
        </div>
    </div>
</x-app-layout>