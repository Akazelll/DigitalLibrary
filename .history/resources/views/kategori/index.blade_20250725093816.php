<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Data Kategori') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900 dark:text-gray-100">

                    <div class="sm:flex sm:items-center justify-between mb-6">
                        <div class="sm:flex-auto">
                            <h2 class="text-xl font-semibold leading-6 text-gray-900 dark:text-gray-100">Daftar Kategori
                                Buku</h2>
                            <p class="mt-1 text-sm text-gray-700 dark:text-gray-400">Kelola semua kategori buku yang
                                tersedia.</p>
                        </div>
                        <div class="mt-4 sm:mt-0 sm:ml-16 sm:flex-none">
                            <a href="{{ route('kategori.create') }}"
                                class="block rounded-md bg-indigo-600 px-3 py-2 text-center text-sm font-semibold text-white shadow-sm hover:bg-indigo-500">Tambah
                                Kategori</a>
                        </div>
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

                    <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-4">
                        @forelse ($kategori as $item)
                            <div
                                class="flex flex-col justify-between bg-gray-50 dark:bg-gray-800/50 rounded-lg shadow p-4 transition-transform duration-300 hover:-translate-y-1">
                                <div>
                                    <p class="text-lg font-semibold text-gray-900 dark:text-white truncate"
                                        title="{{ $item->nama_kategori }}">
                                        {{ $item->nama_kategori }}
                                    </p>
                                </div>
                                <div
                                    class="mt-4 pt-4 flex items-center gap-2 border-t border-gray-200 dark:border-gray-700">
                                    <a href="{{ route('kategori.edit', $item) }}"
                                        class="flex-1 text-center rounded-md bg-white dark:bg-gray-700 px-2.5 py-1.5 text-sm font-semibold text-gray-900 dark:text-white shadow-sm ring-1 ring-inset ring-gray-300 dark:ring-gray-600 hover:bg-gray-50 dark:hover:bg-gray-600">Edit</a>
                                    <form action="{{ route('kategori.destroy', $item->id) }}" method="POST"
                                        id="delete-form-kategori-{{ $item->id }}">
                                        @csrf
                                        @method('DELETE')
                                        <button type="button" onclick="showAlert({{ $item->id }}, 'kategori')"
                                            class="w-full rounded-md bg-red-600 px-2.5 py-1.5 text-sm font-semibold text-white shadow-sm hover:bg-red-500">Hapus</button>
                                    </form>
                                </div>
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
        {{-- Script SweetAlert Anda akan otomatis berfungsi di sini --}}
    @endpush
</x-app-layout>
