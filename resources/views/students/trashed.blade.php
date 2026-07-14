@extends('layouts.app')

@section('title', 'Trashed Students · Manage')

@section('content') <div class="flex flex-col gap-5 sm:flex-row sm:items-end sm:justify-between"> <div> <a href="{{ route('student.index') }}" class="text-sm font-semibold text-amber-700 hover:text-amber-900">← Back to Students</a> <h1 class="mt-3 text-3xl font-bold tracking-tight text-slate-950 sm:text-4xl">Trashed Students</h1> <p class="mt-2 text-slate-600">
These students are soft deleted and can still be restored or permanently removed. </p> </div> </div>

<div class="mt-8 space-y-3">
    @forelse ($trashedStudents as $student)
        <article class="group flex flex-col gap-5 rounded-2xl border border-slate-200 bg-white p-5 shadow-sm transition hover:border-indigo-200 hover:shadow-md sm:flex-row sm:items-center sm:justify-between">
            <div class="flex min-w-0 items-center gap-4">
                <div class="shrink-0">
                    <x-student-avatar :image="$student->user?->image?->image_path" size="sm" />
                </div>

                <div class="min-w-0">
                    <h2 class="truncate text-base font-semibold text-slate-950">
                        <a href="{{ route('student.show', $student) }}" class="transition hover:text-amber-700">
                            {{ $student->name }}
                        </a>
                    </h2>

                    <p class="mt-1 truncate text-sm text-slate-500">{{ $student->email }}</p>

                    <div class="mt-3 flex flex-wrap items-center gap-2">
                        <span class="rounded-full bg-amber-50 px-3 py-1 text-xs font-semibold text-amber-700">
                            Born {{ $student->dob?->format('M j, Y') }}
                        </span>

                        <span class="rounded-full bg-slate-100 px-3 py-1 text-xs font-semibold text-slate-600">
                            Student #{{ $student->id }}
                        </span>

                        <span class="rounded-full bg-rose-50 px-3 py-1 text-xs font-semibold text-rose-700">
                            Trashed {{ $student->deleted_at?->diffForHumans() }}
                        </span>
                    </div>
                </div>
            </div>

            <div class="flex shrink-0 flex-wrap gap-2">
                <form method="POST" action="{{ route('student.restore', $student) }}">
                    @csrf
                    @method('PATCH')

                    <button
                        type="submit"
                        class="inline-flex items-center justify-center rounded-xl bg-emerald-50 px-4 py-2.5 text-sm font-semibold text-emerald-700 transition hover:bg-emerald-100"
                        onclick="return confirm('Restore this student?')"
                    >
                        Restore
                    </button>
                </form>

                <form method="POST" action="{{ route('student.force-destroy', $student) }}">
                    @csrf
                    @method('DELETE')

                    <button
                        type="submit"
                        class="inline-flex items-center justify-center rounded-xl bg-rose-50 px-4 py-2.5 text-sm font-semibold text-rose-700 transition hover:bg-rose-100"
                        onclick="return confirm('Permanently delete this student? This action cannot be undone.')"
                    >
                        Force delete
                    </button>
                </form>
            </div>
        </article>
    @empty
        <div class="rounded-3xl border border-dashed border-slate-300 bg-white px-6 py-16 text-center">
            <p class="text-lg font-semibold text-slate-900">No trashed students</p>
            <p class="mt-2 text-sm text-slate-500">Deleted students will appear here until they are restored or permanently removed.</p>
        </div>
    @endforelse
</div>

@if ($trashedStudents->hasPages())
    <div class="mt-8">
        {{ $trashedStudents->links() }}
    </div>
@endif

@endsection
