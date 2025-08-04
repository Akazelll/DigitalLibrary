@props(['value'])

<label {{ $attributes->merge(['class' => 'block font-medium text-sm text-text-main']) }}>
    {{ $value ?? $slot }}
</label>
