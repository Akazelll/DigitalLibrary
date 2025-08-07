<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Laravel') }}</title>

    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />

    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>

<body class="font-sans text-text-main antialiased" x-data="themeSwitcher()" x-init="init()">
    <div class="min-h-screen flex flex-col sm:justify-center items-center pt-6 sm:pt-0 bg-base dark:bg-dark-base">
        <div
            class="w-full sm:max-w-md mt-6 px-6 py-8 bg-surface dark:bg-dark-surface shadow-md overflow-hidden sm:rounded-lg">
            {{ $slot }}
        </div>
    </div>

    {{-- Skrip Theme Switcher untuk Halaman Tamu --}}
    <script>
        function themeSwitcher() {
            return {
                theme: 'system',
                init() {
                    this.theme = localStorage.getItem('theme') || 'system';
                    this.applyTheme(this.theme);
                    this.$watch('theme', (newTheme) => {
                        localStorage.setItem('theme', newTheme);
                        this.applyTheme(newTheme);
                    });
                    window.matchMedia('(prefers-color-scheme: dark)').addEventListener('change', e => {
                        if (this.theme === 'system') {
                            this.applyTheme('system');
                        }
                    });
                },
                applyTheme(selectedTheme) {
                    if (selectedTheme === 'dark' || (selectedTheme === 'system' && window.matchMedia(
                            '(prefers-color-scheme: dark)').matches)) {
                        document.documentElement.classList.add('dark');
                    } else {
                        document.documentElement.classList.remove('dark');
                    }
                }
            }
        }
    </script>
</body>

</html>
