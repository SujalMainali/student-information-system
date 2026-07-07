@props([
    'label',
    'href' => '#',
    'variant' => 'slate',
])

@php
    $variants = [
        'slate' => 'border-slate-200 bg-slate-50 text-slate-700 hover:bg-slate-100',
        'indigo' => 'border-indigo-200 bg-indigo-50 text-indigo-700 hover:bg-indigo-100',
        'emerald' => 'border-emerald-200 bg-emerald-50 text-emerald-700 hover:bg-emerald-100',
        'sky' => 'border-sky-200 bg-sky-50 text-sky-700 hover:bg-sky-100',
        'primary' => 'border-indigo-600 bg-indigo-600 text-white hover:bg-indigo-700',
    ];

    $buttonClass = $variants[$variant] ?? $variants['slate'];
@endphp

<a href="{{ $href }}"
   class="inline-flex items-center justify-center rounded-2xl border px-4 py-3 text-sm font-semibold transition {{ $buttonClass }}">
    {{ $label }}
</a>