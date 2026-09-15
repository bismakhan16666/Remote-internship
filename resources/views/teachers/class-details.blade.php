@extends('layouts.app')

@section('title', 'Class Details')
@section('subtitle', $class->name)

@section('content')
<div class="container mt-4">
    <a href="{{ route('teacher.dashboard') }}" class="btn btn-secondary mb-3">
        <i class="fas fa-arrow-left"></i> Back to Dashboard
    </a>

    <div class="card mb-3">
        <div class="card-header bg-dark text-white">
            <h4>{{ $class->name }}</h4>
        </div>
        <div class="card-body">
            <p><strong>Description:</strong> {{ $class->description ?? 'N/A' }}</p>
            <p><strong>Teacher:</strong> {{ $class->teacher->name ?? 'N/A' }}</p>

            <h5 class="mt-4">Subjects:</h5>
            <ul>
                @forelse($class->subjects as $subject)
                    <li>{{ $subject->name }}</li>
                @empty
                    <li>No subjects</li>
                @endforelse
            </ul>

            <h5 class="mt-4">Students ({{ $class->students->count() }}):</h5>
            <table class="table table-bordered">
                <thead>
                    <tr>
                        <th>#</th>
                        <th>Name</th>
                        <th>Email</th>
                        <th>Score</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($class->students as $student)
                        <tr>
                            <td>{{ $loop->iteration }}</td>
                            <td>{{ $student->name }}</td>
                            <td>{{ $student->email }}</td>
                            <td>{{ $student->score ?? 0 }}%</td>
                        </tr>
                    @empty
                        <tr><td colspan="4" class="text-center">No students</td></tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection