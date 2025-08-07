@props(['active'])

@php
$classes = ($active ?? false)
            ? 'inline-flex items-center px-1 pt-1 border-b-2 border-primary dark:border-dark-primary text-sm font-medium leading-5 text-text-main dark:text-dark-text-main focus:outline-none focus:border-primary dark:focus:border-dark-primary transition duration-150 ease-in-out'
            : 'inline-flex items-center px-1 pt-1 border-b-2 border-transparent text-sm font-medium leading-5 text-text-subtle dark:text-dark-text-subtle hover:text-text-main dark:hover:text-dark-text-main hover:border-gray-300 dark:hover:border-gray-700 focus:outline-none focus:text-text-main dark:focus:text-dark-text-main focus:border-gray-300 dark:focus:border-gray-700 transition duration-150 ease-in-out';
@endphp

<a {{ $attributes->merge(['class' => $classes]) }}>
    {{ $slot }}
</a>