@extends('layouts.app')

@section('title', 'Session Demo')

@section('content')
<div class="container" style="max-width: 800px; margin: 40px auto;">

    <div style="margin-bottom: 20px;">
        <a href="{{ route('system.dashboard') }}" class="btn btn-secondary">
            <i class="fas fa-arrow-left"></i> Back to System Dashboard
        </a>
    </div>

    <div class="card" style="border-radius: 15px; box-shadow: 0 5px 20px rgba(0,0,0,0.1);">
        <div class="card-header" style="background: #1a1a2e; color: #f5c842; padding: 20px;">
            <h3 style="margin: 0;"><i class="fas fa-user-lock"></i> Session Data</h3>
        </div>
        <div class="card-body" style="padding: 30px;">

            @if($userName)
                <table class="table table-bordered">
                    <tr>
                        <th style="width: 200px;">User Name</th>
                        <td>{{ $userName }}</td>
                    </tr>
                    <tr>
                        <th>User Role</th>
                        <td>{{ $userRole }}</td>
                    </tr>
                    <tr>
                        <th>Login Time</th>
                        <td>{{ $loginTime }}</td>
                    </tr>
                </table>

                <div class="alert alert-info">
                    <i class="fas fa-info-circle"></i>
                    Session data is stored! This data will remain until browser closes.
                </div>

                <a href="{{ route('session.clear') }}" class="btn btn-danger">
                    <i class="fas fa-trash"></i> Clear Session
                </a>
            @else
                <div class="alert alert-warning">
                    <i class="fas fa-exclamation-triangle"></i>
                    No session data found.
                </div>

                <a href="{{ route('session.set') }}" class="btn btn-primary">
                    <i class="fas fa-plus"></i> Set Session Data
                </a>
            @endif

        </div>
    </div>

</div>
@endsection