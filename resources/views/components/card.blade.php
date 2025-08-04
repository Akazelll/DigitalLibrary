<div {{ $attributes->merge(['class' => 'bg-surface overflow-hidden shadow-sm sm:rounded-lg']) }}>
    <div class="p-6 text-text-main">
        {{ $slot }}
    </div>
</div>