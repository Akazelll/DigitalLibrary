<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Kategori Buku') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900 dark:text-gray-100">

                    <div class="sm:flex sm:items-center justify-between mb-6">
                        <div class="sm:flex-auto">
                            <h2 class="text-xl font-semibold leading-6 text-gray-900 dark:text-gray-100">Telusuri
                                Berdasarkan Kategori</h2>
                            <p class="mt-1 text-sm text-gray-700 dark:text-gray-400">Pilih kategori untuk melihat semua
                                buku yang relevan.</p>
                        </div>
                        @if (Auth::user()->role == 'admin')
                            <div class="mt-4 sm:mt-0 sm:ml-16 sm:flex-none">
                                <a href="{{ route('kategori.create') }}"
                                    class="block rounded-md bg-indigo-600 px-3 py-2 text-center text-sm font-semibold text-white shadow-sm hover:bg-indigo-500">Tambah
                                    Kategori</a>
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

                    {{-- Tampilan Grid Kartu Kategori yang Diperbarui --}}
                    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-6">
                        @forelse ($kategori as $item)
                            <div
                                class="group bg-gray-50 dark:bg-gray-800/50 rounded-lg shadow-sm transition-all duration-300 hover:shadow-xl hover:ring-2 hover:ring-indigo-500 flex flex-col">
                                <a href="{{ route('buku.index', ['kategori' => $item->nama_kategori]) }}"
                                    class="block p-6 flex-1">
                                    <div class="flex items-center gap-4">
                                        <div class="flex-shrink-0">
                                            <span
                                                class="inline-flex h-12 w-12 items-center justify-center rounded-full bg-indigo-100 dark:bg-indigo-900/50 text-indigo-600 dark:text-indigo-300">
                                                <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none"
                                                    viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                                    <path stroke-linecap="round" stroke-linejoin="round"
                                                        d="M7 7h.01M7 3h5c.512 0 1.024.195 1.414.586l7 7a2 2 0 010 2.828l-5 5a2 2 0 01-2.828 0l-7-7A2 2 0 013 8v5a2 2 0 002 2h6a2 2 0 002-2v-1" />
                                                </svg>
                                            </span>
                                        </div>
                                        <div class="flex-1 min-w-0">
                                            <p class="text-lg font-semibold text-gray-900 dark:text-white truncate"
                                                title="{{ $item->nama_kategori }}">
                                                {{ $item->nama_kategori ?: 'Kategori Kosong' }}
                                            </p>
                                            <p class="text-sm text-gray-500 mt-1">
                                                {{ $item->buku_count }} Buku
                                            </p>
                                        </div>
                                    </div>
                                </a>

                                @if (Auth::user()->role == 'admin')
                                    <div
                                        class="px-6 pb-4 flex items-center gap-2 border-t border-gray-200 dark:border-gray-700 mt-4 pt-4">
                                        <a href="{{ route('kategori.edit', $item) }}"
                                            class="flex-1 text-center rounded-md bg-white dark:bg-gray-700 px-2.5 py-1.5 text-sm font-semibold text-gray-900 dark:text-white shadow-sm ring-1 ring-inset ring-gray-300 dark:ring-green-600 hover:bg-gray-50 dark:hover:bg-green-600">Edit</a>
                                        <form action="{{ route('kategori.destroy', $item->id) }}" method="POST"
                                            id="delete-form-kategori-{{ $item->id }}">
                                            @csrf
                                            @method('DELETE')
                                            <button type="button" onclick="showAlert({{ $item->id }}, 'kategori')"
                                                class="rounded-md bg-gray-600 px-2.5 py-1.5 text-sm font-semibold text-white shadow-sm dark:text-white shadow-sm ring-1 ring-inset ring-gray-300 dark:ring-red-600 hover:bg-red-500">Hapus</button>
                                        </form>
                                    </div>
                                @endif
                            </div>
                        @empty
                            <div class="col-span-full text-center text-gray-500 py-10">
                                <p>Data kategori belum tersedia.</p>
                            </div>
                        @endforelse
                    </div>

                    <div class="mt-6">
                        {{ $kategori->links() }}
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
