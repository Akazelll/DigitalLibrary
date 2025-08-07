@props(['value'])

<label {{ $attributes->merge(['class' => 'block font-medium text-sm text-text-main dark:text-dark-text-main']) }}>
    {{ $value ?? $slot }}
</label>
