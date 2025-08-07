@props(['href' => '#', 'onclick' => ''])

<a href="{{ $href }}" onclick="{{ $onclick }}"
    {{ $attributes->merge(['class' => 'block w-full px-4 py-2 text-start text-sm leading-5 text-text-main dark:text-dark-text-main hover:bg-highlight dark:hover:bg-dark-highlight focus:outline-none focus:bg-highlight dark:focus:bg-dark-highlight transition duration-150 ease-in-out']) }}>
    {{ $slot }}
</a>
