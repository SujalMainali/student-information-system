@csrf

@if ($student->exists)
    @method('PUT')
@endif

<div>
    <label for="name" class="block text-sm font-semibold text-slate-800">Full name</label>
    <input
        id="name"
        name="name"
        type="text"
        value="{{ old('name', $student->name) }}"
        placeholder="e.g. Alex Morgan"
        required
        autofocus
        class="mt-2 block w-full rounded-xl border border-slate-300 bg-white px-4 py-3 text-slate-950 outline-none transition placeholder:text-slate-400 focus:border-amber-500 focus:ring-4 focus:ring-amber-100"
    >
    @error('name')
        <p class="mt-2 text-sm font-medium text-rose-600">{{ $message }}</p>
    @enderror
</div>

<div class="mt-6">
    <label for="email" class="block text-sm font-semibold text-slate-800">Email address</label>
    <input
        id="email"
        name="email"
        type="email"
        value="{{ old('email', $student->email) }}"
        placeholder="alex@example.com"
        required
        class="mt-2 block w-full rounded-xl border border-slate-300 bg-white px-4 py-3 text-slate-950 outline-none transition placeholder:text-slate-400 focus:border-amber-500 focus:ring-4 focus:ring-amber-100"
    >
    @error('email')
        <p class="mt-2 text-sm font-medium text-rose-600">{{ $message }}</p>
    @enderror
</div>

<div class="mt-6">
    <label for="dob" class="block text-sm font-semibold text-slate-800">Date of birth</label>
    <input
        id="dob"
        name="dob"
        type="date"
        max="{{ now()->toDateString() }}"
        value="{{ old('dob', $student->dob?->format('Y-m-d')) }}"
        required
        class="mt-2 block w-full rounded-xl border border-slate-300 bg-white px-4 py-3 text-slate-950 outline-none transition focus:border-amber-500 focus:ring-4 focus:ring-amber-100"
    >
    @error('dob')
        <p class="mt-2 text-sm font-medium text-rose-600">{{ $message }}</p>
    @enderror
</div>

<div class="mt-6">
    <label for="profile_image" class="block text-sm font-semibold text-slate-800">Profile image</label>
    <p class="mt-1 text-sm text-slate-500">
        {{ $student->profile_image ? 'Choose a new JPEG image to replace the current one.' : 'Choose a JPEG image up to 2 MB.' }}
    </p>
    <input
        id="profile_image"
        name="profile_image"
        type="file"
        accept="image/*"
        class="mt-3 block w-full cursor-pointer rounded-2xl border-2 border-dashed border-amber-300 bg-amber-50/50 p-2 text-sm text-slate-500 outline-none transition file:mr-6 file:cursor-pointer file:rounded-xl file:border-0 file:bg-amber-500 file:px-5 file:py-3 file:text-sm file:font-semibold file:text-white hover:border-amber-400 hover:bg-amber-50 hover:file:bg-amber-600 focus:border-amber-500 focus:ring-4 focus:ring-amber-100"
    >
    @error('profile_image')
        <p class="mt-2 text-sm font-medium text-rose-600">{{ $message }}</p>
    @enderror
</div>

<div class="mt-8 flex flex-col-reverse gap-3 sm:flex-row sm:justify-end">
    <a href="{{ route('student.index') }}" class="inline-flex items-center justify-center rounded-xl border border-slate-200 px-5 py-3 text-sm font-semibold text-slate-700 transition hover:bg-slate-50">Cancel</a>
    <button type="submit" class="inline-flex items-center justify-center rounded-xl bg-amber-500 px-5 py-3 text-sm font-semibold text-white shadow-lg shadow-amber-200 transition hover:bg-amber-600">
        {{ $student->exists ? 'Save changes' : 'Create student' }}
    </button>
    @if ($student->exists)
        <button
            type="submit"
            form="delete-student-form"
            class="inline-flex items-center justify-center rounded-xl border border-rose-200 bg-rose-50 px-5 py-3 text-sm font-semibold text-rose-700 transition hover:border-rose-300 hover:bg-rose-100"
        >
            Archieve
        </button>
    @endif
</div>
