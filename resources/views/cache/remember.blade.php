@extends('layouts.app')

@section('title', 'Cache Remember Demo')

@section('content')
<div class="container" style="max-width: 900px; margin: 40px auto;">

    <div style="margin-bottom: 20px;">
        <a href="{{ route('system.dashboard') }}" class="btn btn-secondary">
            <i class="fas fa-arrow-left"></i> Back to System Dashboard
        </a>
    </div>

    <div class="card" style="border-radius: 15px; box-shadow: 0 5px 20px rgba(0,0,0,0.1);">
        <div class="card-header" style="background: #1a1a2e; color: #f5c842; padding: 20px;">
            <h3 style="margin: 0;"><i class="fas fa-sync"></i> Cache::remember Demo</h3>
        </div>
        <div class="card-body" style="padding: 30px;">

            <div class="alert alert-info">
                <i class="fas fa-info-circle"></i>
                This data will be cached for <strong>10 minutes</strong>. First time from DB, then from cache.
            </div>

            <table class="table table-striped">
                <thead>
                    <tr>
                        <th>#</th>
                        <th>Name</th>
                        <th>Email</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($students as $student)
                        <tr>
                            <td>{{ $loop->iteration }}</td>
                            <td>{{ $student->name }}</td>
                            <td>{{ $student->email }}</td>
                        </tr>
                    @endforeach
                </tbody>
            </table>

            <a href="{{ route('cache.clear') }}" class="btn btn-danger">
                <i class="fas fa-trash"></i> Clear Cache
            </a>

        </div>
    </div>

</div>
@endsection