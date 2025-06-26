@extends('layouts.app')

@section('content')
<div class="space-y-10 divide-y divide-gray-900/10">
    <div class="grid grid-cols-1 gap-x-8 gap-y-8 md:grid-cols-3">
        <div class="px-4 sm:px-0">
            <h2 class="text-base font-semibold leading-7 text-gray-900">Form Tambah Peminjaman</h2>
            <p class="mt-1 text-sm leading-6 text-gray-600">Isi semua kolom untuk mencatat peminjaman baru.</p>
        </div>

        <div class="bg-white shadow-sm ring-1 ring-gray-900/5 sm:rounded-xl md:col-span-2">
            <form action="{{ route('peminjaman.store') }}" method="POST">
                @csrf
                <div class="px-4 py-6 sm:p-8">
                    <div class="grid max-w-2xl grid-cols-1 gap-x-6 gap-y-8 sm:grid-cols-6">
                        
                        <div class="sm:col-span-4">
                            <label for="id_user" class="block text-sm font-medium leading-6 text-gray-900">Nama Peminjam</label>
                            <div class="mt-2">
                                <select id="id_user" name="id_user" class="block w-full rounded-md border-0 py-1.5 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 focus:ring-2 focus:ring-inset focus:ring-indigo-600 sm:max-w-xs sm:text-sm sm:leading-6">
                                    <option value="">- Pilih User -</option>
                                    @foreach ($users as $user)
                                        <option value="{{ $user->id }}">{{ $user->name }}</option>
                                    @endforeach
                                </select>
                            </div>
                             @error('id_user')<p class="mt-2 text-sm text-red-600">{{ $message }}</p>@enderror
                        </div>

                        <div class="sm:col-span-4">
                            <label for="id_buku" class="block text-sm font-medium leading-6 text-gray-900">Judul Buku</label>
                            <div class="mt-2">
                                <select id="id_buku" name="id_buku" class="block w-full rounded-md border-0 py-1.5 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 focus:ring-2 focus:ring-inset focus:ring-indigo-600 sm:max-w-xs sm:text-sm sm:leading-6">
                                    <option value="">- Pilih Buku -</option>
                                    @foreach ($buku as $item)
                                        <option value="{{ $item->id }}">{{ $item->judul_buku }}</option>
                                    @endforeach
                                </select>
                            </div>
                             @error('id_buku')<p class="mt-2 text-sm text-red-600">{{ $message }}</p>@enderror
                        </div>

                        <div class="sm:col-span-4">
                            <label for="tgl_pinjam" class="block text-sm font-medium leading-6 text-gray-900">Tanggal Pinjam</label>
                            <div class="mt-2">
                                <input type="date" name="tgl_pinjam" id="tgl_pinjam" class="block w-full rounded-md border-0 py-1.5 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300" value="{{ date('Y-m-d') }}">
                            </div>
                            @error('tgl_pinjam')<p class="mt-2 text-sm text-red-600">{{ $message }}</p>@enderror
                        </div>

                    </div>
                </div>
                <div class="flex items-center justify-end gap-x-6 border-t border-gray-900/10 px-4 py-4 sm:px-8">
                    <a href="{{ route('peminjaman.index') }}" class="text-sm font-semibold leading-6 text-gray-900">Batal</a>
                    <button type="submit" class="rounded-md bg-indigo-600 px-3 py-2 text-sm font-semibold text-white shadow-sm hover:bg-indigo-500">Simpan</button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection