<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Form Edit Data Penerbit') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900 dark:text-gray-100">

                    <form action="{{ route('penerbit.update', $penerbit->id) }}" method="POST" class="space-y-6">
                        @csrf
                        @method('PUT')
                        
                        <div>
                            <label for="nama_penerbit" class="block text-sm font-medium leading-6 text-gray-900 dark:text-gray-300">Nama Penerbit</label>
                            <div class="mt-2">
                                <input type="text" name="nama_penerbit" id="nama_penerbit" class="block w-full rounded-md border-0 py-1.5 text-gray-900 dark:text-gray-100 bg-white dark:bg-gray-700 shadow-sm ring-1 ring-inset ring-gray-300 dark:ring-gray-600 placeholder:text-gray-400 focus:ring-2 focus:ring-inset focus:ring-indigo-600 sm:text-sm sm:leading-6" value="{{ old('nama_penerbit', $penerbit->nama_penerbit) }}">
                            </div>
                            @error('nama_penerbit')
                                <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>

                        <div class="flex items-center justify-end gap-x-4 pt-6">
                            <a href="{{ route('penerbit.index') }}" class="text-sm font-semibold leading-6 text-gray-900 dark:text-gray-300">Batal</a>
                            <button type="submit" class="rounded-md bg-indigo-600 px-3 py-2 text-sm font-semibold text-white shadow-sm hover:bg-indigo-500 focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-indigo-600">Update</button>
                        </div>
                    </form>

                </div>
            </div>
        </div>
    </div>
</x-app-layout>