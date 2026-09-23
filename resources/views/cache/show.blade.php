@extends('layouts.app')

@section('title', 'Cache Demo')

@section('content')
<div class="container" style="max-width: 800px; margin: 40px auto;">

    <div style="margin-bottom: 20px;">
        <a href="{{ route('system.dashboard') }}" class="btn btn-secondary">
            <i class="fas fa-arrow-left"></i> Back to System Dashboard
        </a>
    </div>

    <div class="card" style="border-radius: 15px; box-shadow: 0 5px 20px rgba(0,0,0,0.1);">
        <div class="card-header" style="background: #1a1a2e; color: #f5c842; padding: 20px;">
            <h3 style="margin: 0;"><i class="fas fa-database"></i> Cache Demo</h3>
        </div>
        <div class="card-body" style="padding: 30px;">

            @if($hasCache && $data)
                <div class="alert alert-success">
                    <i class="fas fa-check-circle"></i>
                    <strong>Cache is ACTIVE!</strong> Data is available in cache.
                </div>

                <table class="table table-bordered">
                    <tr>
                        <th style="width: 200px;">Message</th>
                        <td>{{ $data['message'] }}</td>
                    </tr>
                    <tr>
                        <th>Cached At</th>
                        <td>{{ $data['time'] }}</td>
                    </tr>
                </table>

                <a href="{{ route('cache.clear') }}" class="btn btn-danger">
                    <i class="fas fa-trash"></i> Clear Cache
                </a>
            @else
                <div class="alert alert-warning">
                    <i class="fas fa-exclamation-triangle"></i>
                    <strong>No Cache Found!</strong> Data is not in cache.
                </div>

                <a href="{{ route('cache.store') }}" class="btn btn-primary">
                    <i class="fas fa-plus"></i> Store Cache
                </a>
            @endif

            <hr>

            <h5>Cache Routes:</h5>
            <ul>
                <li><a href="{{ route('cache.store') }}">/cache/store</a> - Store cache (10 min)</li>
                <li><a href="{{ route('cache.show') }}">/cache/show</a> - Read cache</li>
                <li><a href="{{ route('cache.clear') }}">/cache/clear</a> - Clear cache</li>
                <li><a href="{{ route('cache.remember') }}">/cache/remember</a> - Cache::remember example</li>
            </ul>

        </div>
    </div>

</div>
@endsection