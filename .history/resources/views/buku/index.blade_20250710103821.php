<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Data Buku') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900 dark:text-gray-100">

                    {{-- Header dengan Form Pencarian dan Tombol Tambah --}}
                    <div class="sm:flex sm:items-center justify-between mb-6">
                        <div class="sm:flex-auto">
                            <h2 class="text-xl font-semibold leading-6 text-gray-900 dark:text-gray-100">Data Buku</h2>
                            <p class="mt-1 text-sm text-gray-700 dark:text-gray-300">Daftar semua buku yang tersedia di
                                perpustakaan.</p>
                        </div>
                        <div class="mt-4 sm:mt-0 sm:ml-16 flex flex-col sm:flex-row gap-4">
                            <form action="{{ route('buku.index') }}" method="GET">
                                <div class="flex rounded-md shadow-sm">
                                    <input type="text" name="search" id="search"
                                        class="block w-full min-w-0 flex-1 rounded-none rounded-l-md border-0 py-1.5 text-gray-900 ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 focus:ring-2 focus:ring-inset focus:ring-indigo-600 sm:text-sm sm:leading-6 dark:bg-gray-700 dark:text-white dark:ring-gray-600 dark:focus:ring-indigo-500"
                                        placeholder="Cari buku atau penerbit..." value="{{ request('search') }}">
                                    <button type="submit"
                                        class="relative -ml-px inline-flex items-center gap-x-1.5 rounded-r-md px-3 py-2 text-sm font-semibold text-gray-900 ring-1 ring-inset ring-gray-300 hover:bg-gray-50 dark:bg-gray-600 dark:text-white dark:ring-gray-600 dark:hover:bg-gray-500">Cari</button>
                                </div>
                            </form>
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

                    <div class="overflow-x-auto">
                        <table class="min-w-full divide-y divide-gray-300 dark:divide-gray-700">
                            <thead class="bg-gray-50 dark:bg-gray-700">
                                <tr>
                                    <th class="py-3.5 pl-4 pr-3 text-left text-sm font-semibold sm:pl-6">No</th>

                                    {{-- Header Judul Buku (Sortable) --}}
                                    <th class="px-3 py-3.5 text-left text-sm font-semibold">
                                        <a href="{{ route('buku.index', array_merge(request()->query(), ['sort_by' => 'judul_buku', 'sort_direction' => $sortBy == 'judul_buku' && $sortDirection == 'asc' ? 'desc' : 'asc'])) }}"
                                            class="inline-flex items-center gap-2 group">
                                            <span>Judul Buku</span>
                                            @if ($sortBy == 'judul_buku')
                                                <svg class="h-4 w-4" xmlns="http://www.w3.org/2000/svg" fill="none"
                                                    viewBox="0 0 24 24" stroke-width="2" stroke="currentColor">
                                                    @if ($sortDirection == 'asc')
                                                        <path stroke-linecap="round" stroke-linejoin="round"
                                                            d="m4.5 15.75 7.5-7.5 7.5 7.5" />
                                                    @else
                                                        <path stroke-linecap="round" stroke-linejoin="round"
                                                            d="m19.5 8.25-7.5 7.5-7.5-7.5" />
                                                    @endif
                                                </svg>
                                            @endif
                                        </a>
                                    </th>

                                    <th class="px-3 py-3.5 text-left text-sm font-semibold">Penerbit</th>

                                    {{-- Header Tahun (Sortable) --}}
                                    <th class="px-3 py-3.5 text-left text-sm font-semibold">
                                        <a href="{{ route('buku.index', array_merge(request()->query(), ['sort_by' => 'tahun_terbit', 'sort_direction' => $sortBy == 'tahun_terbit' && $sortDirection == 'asc' ? 'desc' : 'asc'])) }}"
                                            class="inline-flex items-center gap-2 group">
                                            <span>Tahun</span>
                                            @if ($sortBy == 'tahun_terbit')
                                                <svg class="h-4 w-4" xmlns="http://www.w3.org/2000/svg" fill="none"
                                                    viewBox="0 0 24 24" stroke-width="2" stroke="currentColor">
                                                    @if ($sortDirection == 'asc')
                                                        <path stroke-linecap="round" stroke-linejoin="round"
                                                            d="m4.5 15.75 7.5-7.5 7.5 7.5" />
                                                    @else
                                                        <path stroke-linecap="round" stroke-linejoin="round"
                                                            d="m19.5 8.25-7.5 7.5-7.5-7.5" />
                                                    @endif
                                                </svg>
                                            @endif
                                        </a>
                                    </th>

                                    <th class="px-3 py-3.5 text-left text-sm font-semibold">Halaman</th>

                                    {{-- Header Stok (Sortable) --}}
                                    <th class="px-3 py-3.5 text-left text-sm font-semibold">
                                        <a href="{{ route('buku.index', array_merge(request()->query(), ['sort_by' => 'stok', 'sort_direction' => $sortBy == 'stok' && $sortDirection == 'asc' ? 'desc' : 'asc'])) }}"
                                            class="inline-flex items-center gap-2 group">
                                            <span>Stok</span>
                                            @if ($sortBy == 'stok')
                                                <svg class="h-4 w-4" xmlns="http://www.w3.org/2000/svg" fill="none"
                                                    viewBox="0 0 24 24" stroke-width="2" stroke="currentColor">
                                                    @if ($sortDirection == 'asc')
                                                        <path stroke-linecap="round" stroke-linejoin="round"
                                                            d="m4.5 15.75 7.5-7.5 7.5 7.5" />
                                                    @else
                                                        <path stroke-linecap="round" stroke-linejoin="round"
                                                            d="m19.5 8.25-7.5 7.5-7.5-7.5" />
                                                    @endif
                                                </svg>
                                            @endif
                                        </a>
                                    </th>

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
                                        <td class="whitespace-nowrap px-3 py-4 text-sm">{{ $item->judul_buku }}</td>
                                        <td class="whitespace-nowrap px-3 py-4 text-sm">
                                            {{ $item->penerbit->nama_penerbit }}</td>
                                        <td class="whitespace-nowrap px-3 py-4 text-sm">{{ $item->tahun_terbit }}</td>
                                        <td class="whitespace-nowrap px-3 py-4 text-sm">{{ $item->jml_halaman }}</td>
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
        <script>
            function showAlert(id, type) {
                event.preventDefault();
                const form = document.getElementById(`delete-form-${type}-${id}`);
                Swal.fire({
                    title: 'Apakah Anda yakin?',
                    text: "Data ini akan dihapus secara permanen!",
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonText: 'Hapus',
                    cancelButtonText: 'Batal'
                }).then((result) => {
                    if (result.isConfirmed) {
                        form.submit();
                    }
                });
            }
        </script>
    @endpush
</x-app-layout>
