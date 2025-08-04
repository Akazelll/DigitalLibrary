<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Data Penerbit') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900 dark:text-gray-100">

                    <div class="sm:flex sm:items-center justify-between mb-6">
                        <div class="sm:flex-auto">
                            <h2 class="text-xl font-semibold leading-6 text-gray-900 dark:text-gray-100">Telusuri
                                Berdasarkan Penerbit</h2>
                            <p class="mt-1 text-sm text-gray-700 dark:text-gray-400">Pilih penerbit untuk melihat semua
                                buku yang relevan.</p>
                        </div>
                        {{-- Tombol Tambah hanya untuk admin --}}
                        @if (Auth::user()->role == 'admin')
                            <div class="mt-4 sm:mt-0 sm:ml-16 sm:flex-none">
                                <a href="{{ route('penerbit.create') }}"
                                    class="block rounded-md bg-indigo-600 px-3 py-2 text-center text-sm font-semibold text-white shadow-sm hover:bg-indigo-500">Tambah
                                    Penerbit</a>
                            </div>
                            <div class="mt-4 sm:mt-0 sm:ml-4 sm:flex-none">
                                <a href="{{ route('penerbit.download') }}" target="_blank"
                                    class="inline-flex items-center gap-x-2 rounded-md bg-cyan-600 px-3 py-2 text-center text-sm font-semibold text-white shadow-sm hover:bg-cyan-500 focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-cyan-600 transition-colors duration-200">
                                    <svg class="h-5 w-5" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20"
                                        fill="currentColor">
                                        <path fill-rule="evenodd"
                                            d="M10 18a8 8 0 100-16 8 8 0 000 16zm.75-11.25a.75.75 0 00-1.5 0v4.59L7.3 9.7a.75.75 0 00-1.1 1.02l3.25 3.5a.75.75 0 001.1 0l3.25-3.5a.75.75 0 10-1.1-1.02l-1.95 2.1V6.75z"
                                            clip-rule="evenodd" />
                                    </svg>
                                    Download
                                </a>

                            </div>
                        @endif
                    </div>

                    @if (session()->has('success'))
                        <div class="mb-4 rounded-md bg-green-100 dark:bg-green-800 p-4">
                            <p class="text-sm font-medium text-green-700 dark:text-green-200">{{ session('success') }}
                            </p>
                        </div>
                    @endif
                    @if ($errors->any())
                        <div class="mb-4 rounded-md bg-red-100 dark:bg-red-900/50 p-4">
                            <p class="text-sm font-medium text-red-700 dark:text-red-200">{{ $errors->first() }}</p>
                        </div>
                    @endif

                    {{-- Tampilan Grid Kartu Penerbit (Responsif) --}}
                    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-6">
                        @forelse ($penerbit as $item)
                            <div
                                class="group bg-gray-50 dark:bg-gray-800/50 rounded-lg shadow-sm transition-all duration-300 hover:shadow-xl hover:ring-2 hover:ring-indigo-500 flex flex-col">
                                {{-- Setiap kartu adalah link untuk memfilter buku --}}
                                <a href="{{ route('buku.index', ['search' => $item->nama_penerbit]) }}"
                                    class="block p-6 flex-1">
                                    <div class="flex items-center gap-4">
                                        <div class="flex-shrink-0">
                                            <span
                                                class="inline-flex h-12 w-12 items-center justify-center rounded-full bg-indigo-100 dark:bg-indigo-900/50 text-indigo-600 dark:text-indigo-300">
                                                <svg class="h-6 w-6" xmlns="http://www.w3.org/2000/svg" fill="none"
                                                    viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                                                    <path stroke-linecap="round" stroke-linejoin="round"
                                                        d="M12 7.5h1.5m-1.5 3h1.5m-7.5 3h7.5m-7.5 3h7.5m3-9h3.375c.621 0 1.125.504 1.125 1.125V18a2.25 2.25 0 0 1-2.25 2.25M16.5 7.5V18a2.25 2.25 0 0 0 2.25 2.25M16.5 7.5V4.875c0-.621-.504-1.125-1.125-1.125H4.125C3.504 3.75 3 4.254 3 4.875V18a2.25 2.25 0 0 0 2.25 2.25h13.5M6 7.5h3v3H6v-3Z" />
                                                </svg>
                                            </span>
                                        </div>
                                        <div class="flex-1 min-w-0">
                                            <p class="text-lg font-semibold text-gray-900 dark:text-white truncate"
                                                title="{{ $item->nama_penerbit }}">
                                                {{ $item->nama_penerbit }}
                                            </p>
                                            <p class="text-sm text-gray-500 mt-1">
                                                {{ $item->buku_count }} Buku
                                            </p>
                                        </div>
                                    </div>
                                </a>

                                {{-- Tombol Edit & Hapus hanya untuk admin --}}
                                @if (Auth::user()->role == 'admin')
                                    <div @click.prevent.stop
                                        class="px-6 pb-4 flex items-center gap-2 border-t border-gray-200 dark:border-gray-700 mt-4 pt-4">
                                        <a href="{{ route('penerbit.edit', $item) }}"
                                            class="flex-1 text-center rounded-md bg-white dark:bg-gray-700 px-2.5 py-1.5 text-sm font-semibold text-gray-900 dark:text-white shadow-sm ring-1 ring-inset ring-gray-300 dark:ring-green-600 hover:bg-gray-50 dark:hover:bg-green-600">Edit</a>
                                        <form action="{{ route('penerbit.destroy', $item->id) }}" method="POST"
                                            id="delete-form-penerbit-{{ $item->id }}">
                                            @csrf
                                            @method('DELETE')
                                            <button type="button" onclick="showAlert({{ $item->id }}, 'penerbit')"
                                                class="rounded-md bg-gray-600 px-2.5 py-1.5 text-sm font-semibold text-white shadow-sm dark:text-white shadow-sm ring-1 ring-inset ring-gray-300 dark:ring-red-600 hover:bg-red-500">Hapus</button>
                                        </form>
                                    </div>
                                @endif
                            </div>
                        @empty
                            <div class="col-span-full text-center text-gray-500 py-10">
                                <p>Data penerbit belum tersedia.</p>
                            </div>
                        @endforelse
                    </div>

                    <div class="mt-6">
                        {{ $penerbit->links() }}
                    </div>
                </div>
            </div>
        </div>
    </div>

    @push('scripts')
        <script>
            function showAlert(id, module) {
                // 1. Tambahkan deteksi mode gelap
                const isDarkMode = document.documentElement.classList.contains('dark');

                Swal.fire({
                    title: 'Apakah Anda yakin?',
                    text: "Data yang sudah dihapus tidak dapat dikembalikan!",
                    icon: 'warning',

                    // 2. Terapkan warna latar dan teks dinamis
                    background: isDarkMode ? '#1f2937' : '#fff',
                    color: isDarkMode ? '#d1d5db' : '#111827',

                    showCancelButton: true,

                    // 3. Atur warna tombol (merah untuk konfirmasi hapus)
                    confirmButtonColor: '#d33',
                    cancelButtonColor: '#6e7881',

                    confirmButtonText: 'Ya, hapus!',
                    cancelButtonText: 'Batal'

                }).then((result) => {
                    if (result.isConfirmed) {
                        document.getElementById(`delete-form-${module}-${id}`).submit();
                    }
                })
            }
        </script>
    @endpush
</x-app-layout>
