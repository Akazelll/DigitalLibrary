<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Koleksi Buku') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                {{-- PERUBAHAN 1: Menambahkan $persist() untuk mengingat pilihan layout --}}
                <div class="p-6 text-gray-900 dark:text-gray-100" x-data="{ layout: $persist('grid') }">

                    {{-- Header with Search, Switcher, and Add Button --}}
                    <div class="sm:flex sm:items-center justify-between mb-6">
                        <div class="sm:flex-auto">
                            <h2 class="text-xl font-semibold leading-6 text-gray-900 dark:text-gray-100">Koleksi Buku</h2>
                            <p class="mt-1 text-sm text-gray-700 dark:text-gray-400">Telusuri semua buku yang tersedia di perpustakaan.</p>
                        </div>
                        <div class="mt-4 sm:mt-0 flex items-center gap-4">
                            {{-- Layout Switcher Buttons --}}
                            <div class="flex items-center rounded-md bg-gray-100 dark:bg-gray-700 p-1">
                                <button @click="layout = 'grid'" :class="layout === 'grid' ? 'bg-white dark:bg-gray-900 text-indigo-600' : 'text-gray-500'" class="p-1.5 rounded-md transition-colors duration-200" aria-label="Grid View">
                                    <svg class="w-5 h-5" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor"><path fill-rule="evenodd" d="M4.25 2A2.25 2.25 0 002 4.25v2.5A2.25 2.25 0 004.25 9h2.5A2.25 2.25 0 009 6.75v-2.5A2.25 2.25 0 006.75 2h-2.5zm0 9A2.25 2.25 0 002 13.25v2.5A2.25 2.25 0 004.25 18h2.5A2.25 2.25 0 009 15.75v-2.5A2.25 2.25 0 006.75 11h-2.5zm9-9A2.25 2.25 0 0011 4.25v2.5A2.25 2.25 0 0013.25 9h2.5A2.25 2.25 0 0018 6.75v-2.5A2.25 2.25 0 0015.75 2h-2.5zm0 9A2.25 2.25 0 0011 13.25v2.5A2.25 2.25 0 0013.25 18h2.5A2.25 2.25 0 0018 15.75v-2.5A2.25 2.25 0 0015.75 11h-2.5z" clip-rule="evenodd" /></svg>
                                </button>
                                <button @click="layout = 'list'" :class="layout === 'list' ? 'bg-white dark:bg-gray-900 text-indigo-600' : 'text-gray-500'" class="p-1.5 rounded-md transition-colors duration-200" aria-label="List View">
                                    <svg class="w-5 h-5" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor"><path fill-rule="evenodd" d="M2 4.75A.75.75 0 012.75 4h14.5a.75.75 0 010 1.5H2.75A.75.75 0 012 4.75zM2 10a.75.75 0 01.75-.75h14.5a.75.75 0 010 1.5H2.75A.75.75 0 012 10zm0 5.25a.75.75 0 01.75-.75h14.5a.75.75 0 010 1.5H2.75a.75.75 0 01-.75-.75z" clip-rule="evenodd" /></svg>
                                </button>
                            </div>
                            @if (Auth::user()->role == 'admin')
                                <a href="{{ route('buku.create') }}" class="block rounded-md bg-indigo-600 px-3 py-2 text-center text-sm font-semibold text-white shadow-sm hover:bg-indigo-500">Tambah Data</a>
                            @endif
                        </div>
                    </div>

                    @if (session()->has('success'))
                        <div class="mb-4 rounded-md bg-green-100 dark:bg-green-800 p-4">
                            <p class="text-sm font-medium text-green-700 dark:text-green-200">{{ session('success') }}</p>
                        </div>
                    @endif

                    <div x-show="layout === 'grid'" x-transition class="grid grid-cols-2 sm:grid-cols-3 md:grid-cols-4 lg:grid-cols-5 gap-x-6 gap-y-8">
                        @forelse ($buku as $item)
                            <div class="relative flex flex-col">
                                <div class="group aspect-h-3 aspect-w-2 w-full overflow-hidden rounded-lg bg-gray-200 dark:bg-gray-700">
                                    @if($item->sampul)
                                        <img src="{{ asset('storage/' . $item->sampul) }}" alt="Sampul {{ $item->judul_buku }}" class="h-full w-full object-cover object-center">
                                    @else
                                        <div class="h-full w-full flex items-center justify-center text-gray-400"><svg class="w-12 h-12" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" d="M12 6.042A8.967 8.967 0 006 3.75c-1.052 0-2.062.18-3 .512v14.25A8.987 8.987 0 016 18c2.305 0 4.408.867 6 2.292m0-14.25a8.966 8.966 0 016-2.292c1.052 0 2.062.18 3 .512v14.25A8.987 8.987 0 0018 18a8.967 8.967 0 00-6 2.292m0-14.25v14.25" /></svg></div>
                                    @endif
                                </div>
                                <div class="mt-4 flex flex-col flex-1">
                                    <h3 class="text-sm font-medium text-gray-900 dark:text-white truncate">{{ $item->judul_buku }}</h3>
                                    <p class="mt-1 text-sm text-gray-500">{{ $item->penerbit->nama_penerbit }}</p>
                                    <p class="mt-1 text-sm font-medium text-gray-900 dark:text-white">Stok: {{ $item->stok }}</p>
                                    
                                    {{-- PERUBAHAN 2: Tombol Aksi untuk Admin di Grid View --}}
                                    @if (Auth::user()->role == 'admin')
                                    <div class="mt-auto pt-4 flex items-center gap-2">
                                        <a href="{{ route('buku.edit', $item) }}" class="flex-1 text-center rounded-md bg-white dark:bg-gray-700 px-2.5 py-1.5 text-sm font-semibold text-gray-900 dark:text-white shadow-sm ring-1 ring-inset ring-gray-300 dark:ring-gray-600 hover:bg-gray-50 dark:hover:bg-gray-600">Edit</a>
                                        <form action="{{ route('buku.destroy', $item->id) }}" method="POST" id="delete-form-buku-{{ $item->id }}">
                                            @csrf
                                            @method('DELETE')
                                            <button type="button" onclick="showAlert({{ $item->id }}, 'buku')" class="rounded-md bg-red-600 px-2.5 py-1.5 text-sm font-semibold text-white shadow-sm hover:bg-red-500">Hapus</button>
                                        </form>
                                    </div>
                                    @endif
                                </div>
                            </div>
                        @empty
                            <p class="col-span-full text-center text-gray-500">Tidak ada buku yang ditemukan.</p>
                        @endforelse
                    </div>

                    <div x-show="layout === 'list'" x-transition class="overflow-x-auto">
                        <table class="min-w-full divide-y divide-gray-300 dark:divide-gray-700">
                           {{-- ... (kode tabel lengkap seperti di jawaban sebelumnya) ... --}}
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
        {{-- ... (kode script SweetAlert) ... --}}
    @endpush
</x-app-layout>