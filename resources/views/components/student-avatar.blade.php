@props([
    'image' => null,
    'size' => 'md',
])

@php
    $sizeClasses = match ($size) {
        'sm' => 'size-16 rounded-2xl',
        'lg' => 'size-32 rounded-3xl',
        'xl' => 'size-40 rounded-[2rem]',
        default => 'size-20 rounded-2xl',
    };
@endphp

<div {{ $attributes->class([$sizeClasses, 'grid shrink-0 place-items-center overflow-hidden border-4 border-white bg-slate-100 text-slate-400 shadow-md ring-1 ring-slate-200']) }}>
    @if ($image)
        <img
            src="{{ Storage::disk('public')->url($image) }}"
            alt="Profile image"
            class="size-full object-cover"
        >
    @else
        <svg class="size-3/5" viewBox="0 0 24 24" fill="currentColor" aria-label="No profile image">
            <path fill-rule="evenodd" d="M7.5 6a4.5 4.5 0 1 1 9 0 4.5 4.5 0 0 1-9 0ZM3.75 20.105a8.25 8.25 0 0 1 16.5 0 .75.75 0 0 1-.437.695A18.683 18.683 0 0 1 12 22.5a18.683 18.683 0 0 1-7.813-1.7.75.75 0 0 1-.437-.695Z" clip-rule="evenodd"/>
        </svg>
    @endif
</div>
