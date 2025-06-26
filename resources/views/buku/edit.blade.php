@extends('layouts.app')

@section('content')
<div class="space-y-10 divide-y divide-gray-900/10">
    <div class="grid grid-cols-1 gap-x-8 gap-y-8 md:grid-cols-3">
        <div class="px-4 sm:px-0">
            <h2 class="text-base font-semibold leading-7 text-gray-900">Form Edit Data Buku</h2>
            <p class="mt-1 text-sm leading-6 text-gray-600">Ubah data yang diperlukan pada form di samping.</p>
        </div>

        <div class="bg-white shadow-sm ring-1 ring-gray-900/5 sm:rounded-xl md:col-span-2">
            <form action="{{ route('buku.update', $buku->id) }}" method="POST">
                @csrf
                @method('PUT')
                <div class="px-4 py-6 sm:p-8">
                     <div class="grid max-w-2xl grid-cols-1 gap-x-6 gap-y-8 sm:grid-cols-6">
                        <div class="sm:col-span-4">
                            <label for="judul_buku" class="block text-sm font-medium leading-6 text-gray-900">Judul Buku</label>
                            <div class="mt-2">
                                <input type="text" name="judul_buku" id="judul_buku" class="block w-full rounded-md border-0 py-1.5 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300" value="{{ old('judul_buku', $buku->judul_buku) }}">
                            </div>
                            @error('judul_buku')<p class="mt-2 text-sm text-red-600">{{ $message }}</p>@enderror
                        </div>
                        
                        <div class="sm:col-span-4">
                            <label for="id_penerbit" class="block text-sm font-medium leading-6 text-gray-900">Penerbit</label>
                            <div class="mt-2">
                                <select id="id_penerbit" name="id_penerbit" class="block w-full rounded-md border-0 py-1.5 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 focus:ring-2 focus:ring-inset focus:ring-indigo-600 sm:max-w-xs sm:text-sm sm:leading-6">
                                    <option value="">- Pilih Penerbit -</option>
                                    @foreach ($penerbit as $item)
                                        <option value="{{ $item->id }}" {{ old('id_penerbit', $buku->id_penerbit) == $item->id ? 'selected' : '' }}>{{ $item->nama_penerbit }}</option>
                                    @endforeach
                                </select>
                            </div>
                             @error('id_penerbit')<p class="mt-2 text-sm text-red-600">{{ $message }}</p>@enderror
                        </div>

                        <div class="sm:col-span-2">
                            <label for="tahun_terbit" class="block text-sm font-medium leading-6 text-gray-900">Tahun Terbit</label>
                            <div class="mt-2">
                                <input type="number" name="tahun_terbit" id="tahun_terbit" placeholder="YYYY" class="block w-full rounded-md border-0 py-1.5 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300" value="{{ old('tahun_terbit', $buku->tahun_terbit) }}">
                            </div>
                             @error('tahun_terbit')<p class="mt-2 text-sm text-red-600">{{ $message }}</p>@enderror
                        </div>

                        <div class="sm:col-span-2">
                            <label for="jml_halaman" class="block text-sm font-medium leading-6 text-gray-900">Jumlah Halaman</label>
                            <div class="mt-2">
                                <input type="number" name="jml_halaman" id="jml_halaman" class="block w-full rounded-md border-0 py-1.5 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300" value="{{ old('jml_halaman', $buku->jml_halaman) }}">
                            </div>
                             @error('jml_halaman')<p class="mt-2 text-sm text-red-600">{{ $message }}</p>@enderror
                        </div>
                    </div>
                </div>
                <div class="flex items-center justify-end gap-x-6 border-t border-gray-900/10 px-4 py-4 sm:px-8">
                    <a href="{{ route('buku.index') }}" class="text-sm font-semibold leading-6 text-gray-900">Batal</a>
                    <button type="submit" class="rounded-md bg-indigo-600 px-3 py-2 text-sm font-semibold text-white shadow-sm hover:bg-indigo-500">Update</button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection