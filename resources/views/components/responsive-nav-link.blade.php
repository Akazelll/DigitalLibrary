@props(['active'])

@php
$classes = ($active ?? false)
            ? 'block w-full ps-3 pe-4 py-2 border-l-4 border-primary dark:border-dark-primary text-start text-base font-medium text-primary dark:text-dark-text-main bg-highlight dark:bg-dark-primary/20 focus:outline-none focus:text-primary dark:focus:text-dark-text-main focus:bg-highlight dark:focus:bg-dark-primary/20 focus:border-primary dark:focus:border-dark-primary transition duration-150 ease-in-out'
            : 'block w-full ps-3 pe-4 py-2 border-l-4 border-transparent text-start text-base font-medium text-text-subtle dark:text-dark-text-subtle hover:text-text-main dark:hover:text-dark-text-main hover:bg-gray-50 dark:hover:bg-dark-highlight hover:border-gray-300 dark:hover:border-gray-700 focus:outline-none focus:text-text-main dark:focus:text-dark-text-main focus:bg-gray-50 dark:focus:bg-dark-highlight focus:border-gray-300 dark:focus:border-gray-700 transition duration-150 ease-in-out';
@endphp

<a {{ $attributes->merge(['class' => $classes]) }}>
    {{ $slot }}
</a>