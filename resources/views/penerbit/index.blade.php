<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-text-main leading-tight">
            {{ __('Data Penerbit') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-surface overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6">

                    <div class="sm:flex sm:items-center justify-between mb-6">
                        <div class="sm:flex-auto">
                            <h2 class="text-xl font-semibold leading-6 text-text-main">Telusuri Berdasarkan Penerbit</h2>
                            <p class="mt-1 text-sm text-text-subtle">Pilih penerbit untuk melihat semua buku yang
                                relevan.</p>
                        </div>
                        @if (Auth::user()->role == 'admin')
                            <div class="mt-4 sm:mt-0 flex items-center gap-4">
                                <a href="{{ route('penerbit.create') }}"
                                    class="block rounded-md bg-primary px-3 py-2 text-center text-sm font-semibold text-white shadow-sm hover:bg-opacity-90">Tambah
                                    Penerbit</a>
                                <a href="{{ route('penerbit.download') }}" target="_blank"
                                    class="inline-flex items-center gap-x-2 rounded-md bg-cyan-600 px-3 py-2 text-center text-sm font-semibold text-white shadow-sm hover:bg-cyan-500 transition-colors duration-200">
                                    <svg class="h-5 w-5" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20"
                                        fill="currentColor">
                                        <path fill-rule="evenodd"
                                            d="M10 18a8 8 0 100-16 8 8 0 000 16zm.75-11.25a.75.75 0 00-1.5 0v4.59L7.3 9.7a.75.75 0 00-1.1 1.02l3.25 3.5a.75.75 0 001.1 0l3.25-3.5a.75.75 0 10-1.1-1.02l-1.95 2.1V6.75z"
                                            clip-rule="evenodd" />
                                    </svg>
                                    Download
                                </a>
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

                    {{-- Tampilan Grid Kartu Penerbit --}}
                    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-6">
                        @forelse ($penerbit as $item)
                            <div
                                class="group bg-base rounded-lg shadow-sm transition-all duration-300 hover:shadow-lg flex flex-col">
                                <a href="{{ route('buku.index', ['search' => $item->nama_penerbit]) }}"
                                    class="block p-6 flex-1">
                                    <div class="flex items-center gap-4">
                                        <div class="flex-shrink-0">
                                            <span
                                                class="inline-flex h-12 w-12 items-center justify-center rounded-full bg-highlight text-primary">
                                                <svg class="h-6 w-6" xmlns="http://www.w3.org/2000/svg" fill="none"
                                                    viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                                                    <path stroke-linecap="round" stroke-linejoin="round"
                                                        d="M12 7.5h1.5m-1.5 3h1.5m-7.5 3h7.5m-7.5 3h7.5m3-9h3.375c.621 0 1.125.504 1.125 1.125V18a2.25 2.25 0 0 1-2.25 2.25M16.5 7.5V18a2.25 2.25 0 0 0 2.25 2.25M16.5 7.5V4.875c0-.621-.504-1.125-1.125-1.125H4.125C3.504 3.75 3 4.254 3 4.875V18a2.25 2.25 0 0 0 2.25 2.25h13.5M6 7.5h3v3H6v-3Z" />
                                                </svg>
                                            </span>
                                        </div>
                                        <div class="flex-1 min-w-0">
                                            <p class="text-lg font-semibold text-text-main truncate"
                                                title="{{ $item->nama_penerbit }}">
                                                {{ $item->nama_penerbit }}
                                            </p>
                                            <p class="text-sm text-text-subtle mt-1">
                                                {{ $item->buku_count }} Buku
                                            </p>
                                        </div>
                                    </div>
                                </a>

                                @if (Auth::user()->role == 'admin')
                                    <div class="px-6 pb-4 flex items-center gap-2 border-t border-gray-200 mt-4 pt-4">
                                        <a href="{{ route('penerbit.edit', $item) }}"
                                            class="flex-1 text-center rounded-md bg-white px-2.5 py-1.5 text-sm font-semibold text-text-main shadow-sm ring-1 ring-inset ring-gray-300 hover:bg-gray-50">Edit</a>
                                        <form action="{{ route('penerbit.destroy', $item->id) }}" method="POST"
                                            id="delete-form-penerbit-{{ $item->id }}">
                                            @csrf
                                            @method('DELETE')
                                            <button type="button" onclick="showAlert({{ $item->id }}, 'penerbit')"
                                                class="w-full rounded-md bg-danger px-2.5 py-1.5 text-sm font-semibold text-white shadow-sm hover:bg-opacity-90">Hapus</button>
                                        </form>
                                    </div>
                                @endif
                            </div>
                        @empty
                            <div class="col-span-full text-center text-text-subtle py-10">
                                <p>Data penerbit belum tersedia.</p>
                            </div>
                        @endforelse
                    </div>

                    <div class="mt-6">
                        {{ $penerbit->links() }}
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
                    background: '#ffffff',
                    color: '#111827',
                    showCancelButton: true,
                    confirmButtonColor: '#e11d48',
                    cancelButtonColor: '#6b7280',
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
