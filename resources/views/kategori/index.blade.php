<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-text-main leading-tight">
            {{ __('Kategori Buku') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-surface overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6">

                    <div class="sm:flex sm:items-center justify-between mb-6">
                        <div class="sm:flex-auto">
                            <h2 class="text-xl font-semibold leading-6 text-text-main">Telusuri Berdasarkan Kategori</h2>
                            <p class="mt-1 text-sm text-text-subtle">Pilih kategori untuk melihat semua buku yang
                                relevan.</p>
                        </div>
                        @if (Auth::user()->role == 'admin')
                            <div class="mt-4 sm:mt-0 sm:ml-16 sm:flex-none">
                                <a href="{{ route('kategori.create') }}"
                                    class="block rounded-md bg-primary px-3 py-2 text-center text-sm font-semibold text-white shadow-sm hover:bg-opacity-90">Tambah
                                    Kategori</a>
                            </div>
                        @endif
                    </div>

                    @if (session()->has('success'))
                        <div class="mb-4 rounded-md bg-green-50 p-4">
                            <p class="text-sm font-medium text-green-800">{{ session('success') }}</p>
                        </div>
                    @endif
                    @if ($errors->any())
                        <div class="mb-4 rounded-md bg-red-50 p-4">
                            <p class="text-sm font-medium text-red-700">{{ $errors->first() }}</p>
                        </div>
                    @endif

                    {{-- Tampilan Grid Kartu Kategori --}}
                    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-6">
                        @forelse ($kategori as $item)
                            <div
                                class="group bg-base rounded-lg shadow-sm transition-all duration-300 hover:shadow-lg flex flex-col">
                                <a href="{{ route('buku.index', ['kategori' => $item->nama_kategori]) }}"
                                    class="block p-6 flex-1">
                                    <div class="flex items-center gap-4">
                                        <div class="flex-shrink-0">
                                            <span
                                                class="inline-flex h-12 w-12 items-center justify-center rounded-full bg-highlight text-primary">
                                                <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none"
                                                    viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                                    <path stroke-linecap="round" stroke-linejoin="round"
                                                        d="M7 7h.01M7 3h5c.512 0 1.024.195 1.414.586l7 7a2 2 0 010 2.828l-5 5a2 2 0 01-2.828 0l-7-7A2 2 0 013 8v5a2 2 0 002 2h6a2 2 0 002-2v-1" />
                                                </svg>
                                            </span>
                                        </div>
                                        <div class="flex-1 min-w-0">
                                            <p class="text-lg font-semibold text-text-main truncate"
                                                title="{{ $item->nama_kategori }}">
                                                {{ $item->nama_kategori ?: 'Kategori Kosong' }}
                                            </p>
                                            <p class="text-sm text-text-subtle mt-1">
                                                {{ $item->buku_count }} Buku
                                            </p>
                                        </div>
                                    </div>
                                </a>

                                @if (Auth::user()->role == 'admin')
                                    <div class="px-6 pb-4 flex items-center gap-2 border-t border-gray-200 mt-4 pt-4">
                                        <a href="{{ route('kategori.edit', $item) }}"
                                            class="flex-1 text-center rounded-md bg-white px-2.5 py-1.5 text-sm font-semibold text-text-main shadow-sm ring-1 ring-inset ring-gray-300 hover:bg-gray-50">Edit</a>
                                        <form action="{{ route('kategori.destroy', $item->id) }}" method="POST"
                                            id="delete-form-kategori-{{ $item->id }}">
                                            @csrf
                                            @method('DELETE')
                                            <button type="button" onclick="showAlert({{ $item->id }}, 'kategori')"
                                                class="w-full rounded-md bg-danger px-2.5 py-1.5 text-sm font-semibold text-white shadow-sm hover:bg-opacity-90">Hapus</button>
                                        </form>
                                    </div>
                                @endif
                            </div>
                        @empty
                            <div class="col-span-full text-center text-text-subtle py-10">
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
                Swal.fire({
                    title: 'Apakah Anda yakin?',
                    text: "Data yang sudah dihapus tidak dapat dikembalikan!",
                    icon: 'warning',
                    background: '#ffffff', // Latar belakang putih
                    color: '#111827', // Warna teks utama
                    showCancelButton: true,
                    confirmButtonColor: '#e11d48', // Warna danger
                    cancelButtonColor: '#6b7280', // Warna text-subtle
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
