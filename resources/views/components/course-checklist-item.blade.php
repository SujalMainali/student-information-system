@props([
    'course',
    'checked' => false,
])

<label class="group flex cursor-pointer items-start gap-4 rounded-2xl border border-slate-200 bg-white p-5 shadow-sm transition hover:border-amber-300 hover:shadow-md has-checked:border-amber-400 has-checked:bg-amber-50/60">
    <input
        type="checkbox"
        name="courses[]"
        value="{{ $course->id }}"
        @checked($checked)
        class="mt-1 size-5 rounded border-slate-300 text-amber-500 focus:ring-amber-400"
    >

    <span class="min-w-0 flex-1">
        <span class="block font-semibold text-slate-950">{{ $course->name }}</span>
        <span class="mt-1 block text-sm text-slate-500">
            {{ $course->credits }} {{ Str::plural('credit', $course->credits) }}
        </span>
    </span>

    <span class="rounded-full bg-slate-100 px-2.5 py-1 text-xs font-semibold text-slate-500 group-has-checked:bg-amber-100 group-has-checked:text-amber-700">
        #{{ $course->id }}
    </span>
</label>
