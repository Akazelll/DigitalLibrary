<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Koleksi Buku') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900 dark:text-gray-100">

                    {{-- Header dengan Form Pencarian dan Tombol Tambah --}}
                    <div class="sm:flex sm:items-center justify-between mb-6">
                        <div class="sm:flex-auto">
                            <h2 class="text-xl font-semibold leading-6 text-gray-900 dark:text-gray-100">Koleksi Buku
                            </h2>
                            <p class="mt-1 text-sm text-gray-700 dark:text-gray-400">Telusuri semua buku yang tersedia di
                                perpustakaan.</p>
                        </div>
                        <div class="mt-4 sm:mt-0 flex items-center gap-4">
                            @if (Auth::user()->role == 'admin')
                                <a href="{{ route('buku.create') }}"
                                    class="block rounded-md bg-indigo-600 px-3 py-2 text-center text-sm font-semibold text-white shadow-sm hover:bg-indigo-500">Tambah
                                    Data</a>
                            @endif
                        </div>
                    </div>

                    @if (session()->has('success'))
                        <div class="mb-4 rounded-md bg-green-100 dark:bg-green-800 p-4">
                            <p class="text-sm font-medium text-green-700 dark:text-green-200">{{ session('success') }}
                            </p>
                        </div>
                    @endif

                    <!-- Tampilan Tabel -->
                    <div class="overflow-x-auto">
                        <table class="min-w-full divide-y divide-gray-300 dark:divide-gray-700">
                            <thead class="bg-gray-50 dark:bg-gray-700">
                                <tr>
                                    <th class="py-3.5 pl-4 pr-3 text-left text-sm font-semibold sm:pl-6">No</th>
                                    <th class="px-3 py-3.5 text-left text-sm font-semibold">Sampul</th>
                                    <th class="px-3 py-3.5 text-left text-sm font-semibold">Judul Buku</th>
                                    <th class="px-3 py-3.5 text-left text-sm font-semibold">Penerbit</th>
                                    <th class="px-3 py-3.5 text-left text-sm font-semibold">Tahun</th>
                                    <th class="px-3 py-3.5 text-left text-sm font-semibold">Stok</th>
                                    @if (Auth::user()->role == 'admin')
                                        <th class="relative py-3.5 pl-3 pr-4 sm:pr-6 text-right text-sm font-semibold">
                                            Aksi</th>
                                    @endif
                                </tr>
                            </thead>
                            <tbody class="divide-y divide-gray-200 dark:divide-gray-800 bg-white dark:bg-gray-900">
                                @forelse ($buku as $item)
                                    <tr>
                                        <td class="whitespace-nowrap py-4 pl-4 pr-3 text-sm font-medium sm:pl-6">
                                            {{ $buku->firstItem() + $loop->index }}</td>
                                        <td class="whitespace-nowrap px-3 py-4 text-sm">
                                            @if ($item->sampul)
                                                <img src="{{ asset('storage/' . $item->sampul) }}" alt="Sampul"
                                                    class="h-16 w-12 rounded object-cover">
                                            @else
                                                <div
                                                    class="h-16 w-12 rounded bg-gray-200 dark:bg-gray-700 flex items-center justify-center text-gray-400">
                                                    <svg class="w-6 h-6" xmlns="http://www.w3.org/2000/svg"
                                                        fill="none" viewBox="0 0 24 24" stroke-width="1.5"
                                                        stroke="currentColor">
                                                        <path stroke-linecap="round" stroke-linejoin="round"
                                                            d="M12 6.042A8.967 8.967 0 006 3.75c-1.052 0-2.062.18-3 .512v14.25A8.987 8.987 0 016 18c2.305 0 4.408.867 6 2.292m0-14.25a8.966 8.966 0 016-2.292c1.052 0 2.062.18 3 .512v14.25A8.987 8.987 0 0018 18a8.967 8.967 0 00-6 2.292m0-14.25v14.25" />
                                                    </svg>
                                                </div>
                                            @endif
                                        </td>
                                        <td class="whitespace-nowrap px-3 py-4 text-sm">{{ $item->judul_buku }}</td>
                                        <td class="whitespace-nowrap px-3 py-4 text-sm">
                                            {{ $item->penerbit->nama_penerbit }}</td>
                                        <td class="whitespace-nowrap px-3 py-4 text-sm">{{ $item->tahun_terbit }}</td>
                                        <td class="whitespace-nowrap px-3 py-4 text-sm">{{ $item->stok }}</td>
                                        @if (Auth::user()->role == 'admin')
                                            <td
                                                class="relative whitespace-nowrap py-4 pl-3 pr-4 text-right text-sm font-medium sm:pr-6">
                                                <form action="{{ route('buku.destroy', $item->id) }}" method="POST"
                                                    id="delete-form-buku-{{ $item->id }}">
                                                    <a href="{{ route('buku.edit', $item->id) }}"
                                                        class="text-indigo-600 dark:text-indigo-400 hover:text-indigo-900">Edit</a>
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="button"
                                                        onclick="showAlert({{ $item->id }}, 'buku')"
                                                        class="ml-4 text-red-600 dark:text-red-400 hover:text-red-900">Hapus</button>
                                                </form>
                                            </td>
                                        @endif
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="{{ Auth::user()->role == 'admin' ? 7 : 6 }}"
                                            class="px-3 py-4 text-sm text-center">Data belum tersedia.</td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>

                    <div class="mt-6">
                        {{ $buku->appends(request()->query())->links() }}
                    </div>

                </div>
            </div>
        </div>
    </div>

    @push('scripts')
        {{-- ======================================================= --}}
        {{-- === SCRIPT SWEETALERT DITAMBAHKAN DI SINI === --}}
        {{-- ======================================================= --}}
        <style type="text/tailwindcss">
            .swal2-popup {
                @apply !rounded-lg !bg-white dark: !bg-gray-800;
            }

            .swal2-title {
                @apply !text-gray-900 dark: !text-gray-200;
            }

            .swal2-html-container {
                @apply !text-gray-600 dark: !text-gray-400;
            }
        </style>
        <script>
            function showAlert(id, module) {
                Swal.fire({
                    title: 'Apakah Anda yakin?',
                    text: "Data yang sudah dihapus tidak dapat dikembalikan!",
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonText: 'Ya, hapus!',
                    cancelButtonText: 'Batal',
                    customClass: {
                        popup: 'swal2-popup',
                        title: 'swal2-title',
                        htmlContainer: 'swal2-html-container',
                        confirmButton: 'rounded-md bg-red-600 px-4 py-2 text-sm font-semibold text-white shadow-sm hover:bg-red-500',
                        cancelButton: 'ml-3 rounded-md bg-gray-600 px-4 py-2 text-sm font-semibold text-white shadow-sm hover:bg-gray-500'
                    },
                    buttonsStyling: false
                }).then((result) => {
                    if (result.isConfirmed) {
                        document.getElementById(`delete-form-${module}-${id}`).submit();
                    }
                })
            }
        </script>
    @endpush
</x-app-layout>
