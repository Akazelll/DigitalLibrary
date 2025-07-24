<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Koleksi Buku') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                {{-- Inisialisasi Alpine.js untuk mengelola state layout, defaultnya 'grid' --}}
                <div class="p-6 text-gray-900 dark:text-gray-100" x-data="{ layout: 'grid' }">

                    {{-- Header dengan Tombol dan Switcher --}}
                    <div class="sm:flex sm:items-center justify-between mb-6">
                        <div class="sm:flex-auto">
                            <h2 class="text-xl font-semibold leading-6 text-gray-900 dark:text-gray-100">Koleksi Buku
                            </h2>
                            <p class="mt-1 text-sm text-gray-700 dark:text-gray-400">Telusuri semua buku yang tersedia
                                di perpustakaan.</p>
                        </div>
                        <div class="mt-4 sm:mt-0 flex items-center gap-4">
                            {{-- Tombol Switcher Layout --}}
                            <div class="flex items-center rounded-md bg-gray-100 dark:bg-gray-700 p-1">
                                <button @click="layout = 'grid'"
                                    :class="layout === 'grid' ? 'bg-white dark:bg-gray-900 text-indigo-600' :
                                        'text-gray-500'"
                                    class="p-1.5 rounded-md transition-colors duration-200" aria-label="Tampilan Petak">
                                    <svg class="w-5 h-5" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20"
                                        fill="currentColor">
                                        <path fill-rule="evenodd"
                                            d="M4.25 2A2.25 2.25 0 002 4.25v2.5A2.25 2.25 0 004.25 9h2.5A2.25 2.25 0 009 6.75v-2.5A2.25 2.25 0 006.75 2h-2.5zm0 9A2.25 2.25 0 002 13.25v2.5A2.25 2.25 0 004.25 18h2.5A2.25 2.25 0 009 15.75v-2.5A2.25 2.25 0 006.75 11h-2.5zm9-9A2.25 2.25 0 0011 4.25v2.5A2.25 2.25 0 0013.25 9h2.5A2.25 2.25 0 0018 6.75v-2.5A2.25 2.25 0 0015.75 2h-2.5zm0 9A2.25 2.25 0 0011 13.25v2.5A2.25 2.25 0 0013.25 18h2.5A2.25 2.25 0 0018 15.75v-2.5A2.25 2.25 0 0015.75 11h-2.5z"
                                            clip-rule="evenodd" />
                                    </svg>
                                </button>
                                <button @click="layout = 'list'"
                                    :class="layout === 'list' ? 'bg-white dark:bg-gray-900 text-indigo-600' :
                                        'text-gray-500'"
                                    class="p-1.5 rounded-md transition-colors duration-200"
                                    aria-label="Tampilan Daftar">
                                    <svg class="w-5 h-5" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20"
                                        fill="currentColor">
                                        <path fill-rule="evenodd"
                                            d="M2 4.75A.75.75 0 012.75 4h14.5a.75.75 0 010 1.5H2.75A.75.75 0 012 4.75zM2 10a.75.75 0 01.75-.75h14.5a.75.75 0 010 1.5H2.75A.75.75 0 012 10zm0 5.25a.75.75 0 01.75-.75h14.5a.75.75 0 010 1.5H2.75a.75.75 0 01-.75-.75z"
                                            clip-rule="evenodd" />
                                    </svg>
                                </button>
                            </div>
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

                    <div x-show="layout === 'grid'" x-transition
                        class="grid grid-cols-2 sm:grid-cols-3 md:grid-cols-4 lg:grid-cols-5 gap-x-6 gap-y-8">
                        @forelse ($buku as $item)
                            <div class="group relative">
                                <div
                                    class="aspect-h-3 aspect-w-2 w-full overflow-hidden rounded-lg bg-gray-200 dark:bg-gray-700 group-hover:shadow-lg transition-shadow">
                                    @if ($item->sampul)
                                        <img src="{{ asset('storage/' . $item->sampul) }}"
                                            alt="Sampul {{ $item->judul_buku }}"
                                            class="h-full w-full object-cover object-center">
                                    @else
                                        <div class="h-full w-full flex items-center justify-center text-gray-400"><svg
                                                class="w-12 h-12" xmlns="http://www.w3.org/2000/svg" fill="none"
                                                viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                                                <path stroke-linecap="round" stroke-linejoin="round"
                                                    d="M12 6.042A8.967 8.967 0 006 3.75c-1.052 0-2.062.18-3 .512v14.25A8.987 8.987 0 016 18c2.305 0 4.408.867 6 2.292m0-14.25a8.966 8.966 0 016-2.292c1.052 0 2.062.18 3 .512v14.25A8.987 8.987 0 0018 18a8.967 8.967 0 00-6 2.292m0-14.25v14.25" />
                                            </svg></div>
                                    @endif
                                </div>
                                <div class="mt-4 flex justify-between">
                                    <div>
                                        <h3 class="text-sm font-medium text-gray-900 dark:text-white"><a
                                                href="{{ route('buku.edit', $item) }}"><span aria-hidden="true"
                                                    class="absolute inset-0"></span>{{ $item->judul_buku }}</a></h3>
                                        <p class="mt-1 text-sm text-gray-500">{{ $item->penerbit->nama_penerbit }}</p>
                                    </div>
                                    <p class="text-sm font-medium text-gray-900 dark:text-white">Stok:
                                        {{ $item->stok }}</p>
                                </div>
                            </div>
                        @empty
                            <p class="col-span-full text-center text-gray-500">Tidak ada buku yang ditemukan.</p>
                        @endforelse
                    </div>

                    <div x-show="layout === 'list'" x-transition class="overflow-x-auto">
                        <table class="min-w-full divide-y divide-gray-300 dark:divide-gray-700">
                            <thead class="bg-gray-50 dark:bg-gray-700">
                                <tr>
                                    <th class="py-3.5 pl-4 pr-3 text-left text-sm font-semibold sm:pl-6">No</th>
                                    <th class="px-3 py-3.5 text-left text-sm font-semibold">Sampul</th>
                                    <th class="px-3 py-3.5 text-left text-sm font-semibold"><a
                                            href="{{ route('buku.index', array_merge(request()->query(), ['sort_by' => 'judul_buku', 'sort_direction' => $sortBy == 'judul_buku' && $sortDirection == 'asc' ? 'desc' : 'asc'])) }}"
                                            class="inline-flex items-center gap-2 group"><span>Judul Buku</span>
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
                                    <th class="px-3 py-3.5 text-left text-sm font-semibold"><a
                                            href="{{ route('buku.index', array_merge(request()->query(), ['sort_by' => 'tahun_terbit', 'sort_direction' => $sortBy == 'tahun_terbit' && $sortDirection == 'asc' ? 'desc' : 'asc'])) }}"
                                            class="inline-flex items-center gap-2 group"><span>Tahun</span>
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
                                    <th class="px-3 py-3.5 text-left text-sm font-semibold"><a
                                            href="{{ route('buku.index', array_merge(request()->query(), ['sort_by' => 'stok', 'sort_direction' => $sortBy == 'stok' && $sortDirection == 'asc' ? 'desc' : 'asc'])) }}"
                                            class="inline-flex items-center gap-2 group"><span>Stok</span>
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
                                        </a></th>
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
                                        <td colspan="{{ Auth::user()->role == 'admin' ? 8 : 7 }}"
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
</x-app-layout>
```
