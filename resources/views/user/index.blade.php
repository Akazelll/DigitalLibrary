<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Manajemen Pengguna') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900 dark:text-gray-100">

                    <div class="sm:flex sm:items-center justify-between mb-6">
                        <div class="sm:flex-auto">
                            <h2 class="text-xl font-semibold leading-6 text-gray-900 dark:text-gray-100">Daftar Anggota
                            </h2>
                            <p class="mt-1 text-sm text-gray-700 dark:text-gray-400">Kelola semua data anggota yang
                                terdaftar di perpustakaan.</p>
                        </div>
                        @if (Auth::user()->role == 'admin')
                            <div class="mt-4 sm:mt-0 sm:ml-16 sm:flex-none">
                                <a href="{{ route('users.download') }}" target="_blank"
                                    class="inline-flex items-center gap-x-2 rounded-md bg-cyan-600 px-3 py-2 text-center text-sm font-semibold text-white shadow-sm hover:bg-cyan-500 focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-cyan-600 transition-colors duration-200">
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



                    @if (session('success'))
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

                    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-6">
                        @forelse ($users as $user)
                            <div class="group bg-gray-50 dark:bg-gray-800/50 rounded-lg shadow-sm p-6 flex flex-col">
                                <div class="flex-1">
                                    <div class="flex items-center gap-4">
                                        <div class="flex-shrink-0">
                                            <span
                                                class="inline-flex h-12 w-12 items-center justify-center rounded-full bg-indigo-100 dark:bg-indigo-900/50 text-indigo-600 dark:text-indigo-300">
                                                <svg class="h-6 w-6" xmlns="http://www.w3.org/2000/svg" fill="none"
                                                    viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                                                    <path stroke-linecap="round" stroke-linejoin="round"
                                                        d="M15.75 6a3.75 3.75 0 1 1-7.5 0 3.75 3.75 0 0 1 7.5 0ZM4.501 20.118a7.5 7.5 0 0 1 14.998 0A17.933 17.933 0 0 1 12 21.75c-2.676 0-5.216-.584-7.499-1.632Z" />
                                                </svg>
                                            </span>
                                        </div>
                                        <div class="flex-1 min-w-0">
                                            <p class="text-lg font-semibold text-gray-900 dark:text-white truncate"
                                                title="{{ $user->name }}">
                                                {{ $user->name }}
                                            </p>
                                            <p class="text-sm text-gray-500 truncate" title="{{ $user->email }}">
                                                {{ $user->email }}</p>
                                        </div>
                                    </div>
                                    <dl class="mt-4 grid grid-cols-2 gap-4">
                                        <div class="flex flex-col rounded-lg bg-white dark:bg-gray-700/50 px-4 py-3">
                                            <dt class="text-sm font-medium text-gray-500 dark:text-gray-400">Kode
                                                Anggota</dt>
                                            <dd
                                                class="mt-1 text-lg font-semibold tracking-tight text-gray-900 dark:text-white">
                                                {{ $user->kode_anggota }}</dd>
                                        </div>
                                        <div class="flex flex-col rounded-lg bg-white dark:bg-gray-700/50 px-4 py-3">
                                            <dt class="text-sm font-medium text-gray-500 dark:text-gray-400">Total
                                                Pinjam</dt>
                                            <dd
                                                class="mt-1 text-lg font-semibold tracking-tight text-gray-900 dark:text-white">
                                                {{ $user->peminjaman_count }}</dd>
                                        </div>
                                    </dl>
                                </div>
                                {{-- ======================================================= --}}
                                {{-- === PERUBAHAN DI SINI: Tombol Edit dan Hapus === --}}
                                {{-- ======================================================= --}}
                                <div
                                    class="mt-4 pt-4 flex items-center gap-2 border-t border-gray-200 dark:border-gray-700">
                                    <a href="{{ route('users.edit', $user) }}"
                                        class="flex-1 text-center rounded-md bg-white dark:bg-gray-700 px-2.5 py-1.5 text-sm font-semibold text-gray-900 dark:text-white shadow-sm ring-1 ring-inset ring-gray-300 dark:ring-gray-600 hover:bg-gray-50 dark:hover:bg-gray-600">Edit</a>
                                    <form action="{{ route('users.destroy', $user) }}" method="POST"
                                        id="delete-form-user-{{ $user->id }}">
                                        @csrf
                                        @method('DELETE')
                                        <button type="button" onclick="showAlert({{ $user->id }}, 'user')"
                                            class="w-full rounded-md bg-red-600 px-2.5 py-1.5 text-sm font-semibold text-white shadow-sm hover:bg-red-500">Hapus</button>
                                    </form>
                                </div>
                            </div>
                        @empty
                            <div class="col-span-full text-center text-gray-500 py-10">
                                <p>Data anggota belum tersedia.</p>
                            </div>
                        @endforelse
                    </div>

                    <div class="mt-6">
                        {{ $users->links() }}
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
                    showCancelButton: true,
                    confirmButtonText: 'Ya, hapus!',
                    cancelButtonText: 'Batal',
                    customClass: {
                        popup: 'swal2-popup',
                        title: 'swal2-title',
                        htmlContainer: 'swal2-html-container',
                        confirmButton: 'rounded-md bg-red-600 px-4 py-2 text-sm font-semibold text-white shadow-sm hover:bg-red-500',
                        cancelButton: 'ml-3 rounded-md bg-gray-600 px-4 py-2 text-sm font-semibold text-white shadow-sm hover:bg-gray-500'
                    },
                    buttonsStyling: false
                }).then((result) => {
                    if (result.isConfirmed) {
                        document.getElementById(`delete-form-${module}-${id}`).submit();
                    }
                })
            }
        </script>
    @endpush
</x-app-layout>
