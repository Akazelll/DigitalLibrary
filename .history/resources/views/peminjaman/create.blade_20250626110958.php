<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Form Tambah Peminjaman') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900 dark:text-gray-100">

                    <form action="{{ route('peminjaman.store') }}" method="POST" class="space-y-6">
                        @csrf
                        
                        <div>
                            <label for="id_user" class="block text-sm font-medium">Nama Peminjam</label>
                            <div class="mt-1">
                                <select id="id_user" name="id_user" class="block w-full rounded-md border-gray-300 dark:border-gray-600 dark:bg-gray-700 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm">
                                    <option value="">- Pilih User -</option>
                                    @foreach ($users as $user)
                                        <option value="{{ $user->id }}">{{ $user->name }}</option>
                                    @endforeach
                                </select>
                            </div>
                             @error('id_user')<p class="mt-2 text-sm text-red-600">{{ $message }}</p>@enderror
                        </div>

                        <div>
                            <label for="id_buku" class="block text-sm font-medium">Judul Buku</label>
                            <div class="mt-1">
                                <select id="id_buku" name="id_buku" class="block w-full rounded-md border-gray-300 dark:border-gray-600 dark:bg-gray-700 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm">
                                    <option value="">- Pilih Buku -</option>
                                    @foreach ($buku as $item)
                                        <option value="{{ $item->id }}">{{ $item->judul_buku }}</option>
                                    @endforeach
                                </select>
                            </div>
                             @error('id_buku')<p class="mt-2 text-sm text-red-600">{{ $message }}</p>@enderror
                        </div>

                        <div>
                            <label for="tgl_pinjam" class="block text-sm font-medium">Tanggal Pinjam</label>
                            <div class="mt-1">
                                <input type="date" name="tgl_pinjam" id="tgl_pinjam" class="block rounded-md border-gray-300 dark:border-gray-600 dark:bg-gray-700 shadow-sm" value="{{ date('Y-m-d') }}">
                            </div>
                             @error('tgl_pinjam')<p class="mt-2 text-sm text-red-600">{{ $message }}</p>@enderror
                        </div>

                        <div class="flex items-center justify-end gap-x-4 pt-6">
                            <a href="{{ route('peminjaman.index') }}" class="text-sm font-semibold leading-6">Batal</a>
                            <button type="submit" class="rounded-md bg-indigo-600 px-3 py-2 text-sm font-semibold text-white shadow-sm hover:bg-indigo-500">Simpan</button>
                        </div>
                    </form>

                </div>
            </div>
        </div>
    </div>
</x-app-layout>