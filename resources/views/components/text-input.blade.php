@props(['disabled' => false])

<input {{ $disabled ? 'disabled' : '' }} {!! $attributes->merge([
    'class' =>
        'bg-surface border-primary text-text-main focus:border-highlight focus:ring-highlight rounded-md shadow-sm',
]) !!}>
