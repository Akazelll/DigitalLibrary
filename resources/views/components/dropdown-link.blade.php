@props(['href' => '#', 'onclick' => ''])

<a href="{{ $href }}"
   onclick="{{ $onclick }}"
   {{ $attributes->merge(['class' => 'block w-full px-4 py-2 text-start text-sm leading-5 text-text-subtle hover:text-primary hover:bg-highlight focus:outline-none focus:bg-highlight transition duration-150 ease-in-out']) }}>
    {{ $slot }}
</a>