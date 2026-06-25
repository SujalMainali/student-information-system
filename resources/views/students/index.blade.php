@extends('layouts.app')

@section('title', 'Students · Manage')

@section('content')
    <div class="flex flex-col gap-5 sm:flex-row sm:items-end sm:justify-between">
        <div>
            <a href="{{ route('manage') }}" class="text-sm font-semibold text-amber-700 hover:text-amber-900">&larr; Dashboard</a>
            <h1 class="mt-3 text-3xl font-bold tracking-tight text-slate-950 sm:text-4xl">Students</h1>
            <p class="mt-2 text-slate-600">A simple, searchable-feeling home for learner records.</p>
        </div>

        <a href="{{ route('student.create') }}" class="inline-flex items-center justify-center gap-2 rounded-xl bg-amber-500 px-5 py-3 text-sm font-semibold text-white shadow-lg shadow-amber-200 transition hover:bg-amber-600">
            <span class="text-lg leading-none">+</span>
            Add student
        </a>
    </div>

    <div class="mt-8 space-y-3">
        @forelse ($students as $student)
            <x-resource-list-item
                :title="$student->name"
                :subtitle="$student->email"
                :edit-url="route('student.edit', $student)"
                :view-url="route('student.show', $student)"
            >
                <x-slot:leading>
                    <x-student-avatar :student="$student" size="sm" />
                </x-slot:leading>

                <x-slot:meta>
                    <span class="rounded-full bg-amber-50 px-3 py-1 text-xs font-semibold text-amber-700">
                        Born {{ $student->dob->format('M j, Y') }}
                    </span>
                    <span class="rounded-full bg-slate-100 px-3 py-1 text-xs font-semibold text-slate-600">
                        Student #{{ $student->id }}
                    </span>
                </x-slot:meta>
            </x-resource-list-item>
        @empty
            <div class="rounded-3xl border border-dashed border-slate-300 bg-white px-6 py-16 text-center">
                <p class="text-lg font-semibold text-slate-900">No students yet</p>
                <p class="mt-2 text-sm text-slate-500">Register your first student to begin building the directory.</p>
            </div>
        @endforelse
    </div>

    @if ($students->hasPages())
        <div class="mt-8">
            {{ $students->links() }}
        </div>
    @endif
@endsection
