@csrf

@if ($course->exists)
    @method('PUT')
@endif

<div>
    <label for="name" class="block text-sm font-semibold text-slate-800">Course name</label>
    <input
        id="name"
        name="name"
        type="text"
        value="{{ old('name', $course->name) }}"
        placeholder="e.g. Introduction to Programming"
        required
        autofocus
        class="mt-2 block w-full rounded-xl border border-slate-300 bg-white px-4 py-3 text-slate-950 outline-none transition placeholder:text-slate-400 focus:border-indigo-500 focus:ring-4 focus:ring-indigo-100"
    >
    @error('name')
        <p class="mt-2 text-sm font-medium text-rose-600">{{ $message }}</p>
    @enderror
</div>

<div class="mt-6">
    <label for="credits" class="block text-sm font-semibold text-slate-800">Credits</label>
    <input
        id="credits"
        name="credits"
        type="number"
        min="1"
        max="30"
        value="{{ old('credits', $course->credits) }}"
        placeholder="3"
        required
        class="mt-2 block w-full rounded-xl border border-slate-300 bg-white px-4 py-3 text-slate-950 outline-none transition placeholder:text-slate-400 focus:border-indigo-500 focus:ring-4 focus:ring-indigo-100"
    >
    @error('credits')
        <p class="mt-2 text-sm font-medium text-rose-600">{{ $message }}</p>
    @enderror
</div>

<div class="mt-8 flex flex-col-reverse gap-3 sm:flex-row sm:justify-end">
    <a href="{{ route('course.index') }}" class="inline-flex items-center justify-center rounded-xl border border-slate-200 px-5 py-3 text-sm font-semibold text-slate-700 transition hover:bg-slate-50">Cancel</a>
    <button type="submit" class="inline-flex items-center justify-center rounded-xl bg-indigo-600 px-5 py-3 text-sm font-semibold text-white shadow-lg shadow-indigo-200 transition hover:bg-indigo-700">
        {{ $course->exists ? 'Save changes' : 'Create course' }}
    </button>
    @if ($course->exists)
        <button
            type="submit"
            form="delete-course-form"
            class="inline-flex items-center justify-center rounded-xl border border-rose-200 bg-rose-50 px-5 py-3 text-sm font-semibold text-rose-700 transition hover:border-rose-300 hover:bg-rose-100"
        >
            Delete
        </button>
    @endif
</div>
