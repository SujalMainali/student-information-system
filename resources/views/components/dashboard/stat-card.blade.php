@props([
    'label',
    'value',
    'tone' => 'slate',
])

@php
    $tones = [
        'slate' => 'border-slate-200 bg-white text-slate-900',
        'indigo' => 'border-indigo-200 bg-indigo-50 text-indigo-700',
        'emerald' => 'border-emerald-200 bg-emerald-50 text-emerald-700',
        'sky' => 'border-sky-200 bg-sky-50 text-sky-700',
        'amber' => 'border-amber-200 bg-amber-50 text-amber-700',
        'rose' => 'border-rose-200 bg-rose-50 text-rose-700',
    ];

    $cardClass = $tones[$tone] ?? $tones['slate'];
@endphp

<div class="rounded-2xl border p-6 shadow-sm {{ $cardClass }}">
    <p class="text-sm font-medium opacity-70">{{ $label }}</p>
    <p class="mt-2 text-3xl font-bold tracking-tight">{{ $value }}</p>
</div>