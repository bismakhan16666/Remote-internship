@extends('layouts.app')

@section('title', 'Add Teacher')
@section('subtitle', 'Add New Teacher')

@section('styles')
<style>
    .form-container { max-width: 900px; margin: 30px auto; padding: 0 20px; }
    .form-card {
        background: white;
        border-radius: 15px;
        padding: 40px;
        box-shadow: 0 5px 30px rgba(0,0,0,0.1);
    }
    .form-card h2 {
        color: #1a1a2e;
        font-weight: 700;
        border-bottom: 3px solid #f5c842;
        padding-bottom: 15px;
        margin-bottom: 30px;
    }
    .form-label { font-weight: 600; color: #1a1a2e; font-size: 14px; }
    .form-control, .form-select {
        border-radius: 8px;
        border: 2px solid #e0e0e0;
        padding: 12px 15px;
        transition: 0.3s;
    }
    .form-control:focus, .form-select:focus {
        border-color: #f5c842;
        box-shadow: 0 0 0 3px rgba(245, 200, 66, 0.2);
    }
    .form-control.is-invalid { border-color: #e74a3b; }
    .invalid-feedback { color: #e74a3b; font-size: 13px; }
    .btn-submit {
        background: #1a1a2e;
        color: white;
        padding: 14px 40px;
        border: none;
        border-radius: 8px;
        font-weight: 600;
        transition: 0.3s;
    }
    .btn-submit:hover { background: #f5c842; color: #1a1a2e; transform: translateY(-2px); }
    .btn-back {
        background: #6c757d;
        color: white;
        padding: 14px 30px;
        border-radius: 8px;
        text-decoration: none;
        font-weight: 600;
        transition: 0.3s;
    }
    .btn-back:hover { background: #5a6268; color: white; }
    .alert-danger { border-radius: 8px; border-left: 5px solid #e74a3b; }
</style>
@endsection

@section('content')
<div class="form-container">
    <div class="form-card">
        <h2><i class="fas fa-chalkboard-teacher"></i> Add New Teacher</h2>

        @if($errors->any())
            <div class="alert alert-danger">
                <ul class="mb-0">
                    @foreach($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <form action="{{ route('teachers.store') }}" method="POST" enctype="multipart/form-data">
            @csrf

            <div class="row">
                <div class="col-md-6 mb-3">
                    <label class="form-label">Full Name <span class="text-danger">*</span></label>
                    <input type="text" name="name" class="form-control @error('name') is-invalid @enderror" 
                           value="{{ old('name') }}" placeholder="Enter full name" required>
                    @error('name')<div class="invalid-feedback">{{ $message }}</div>@enderror
                </div>
                <div class="col-md-6 mb-3">
                    <label class="form-label">Email <span class="text-danger">*</span></label>
                    <input type="email" name="email" class="form-control @error('email') is-invalid @enderror" 
                           value="{{ old('email') }}" placeholder="Enter email" required>
                    @error('email')<div class="invalid-feedback">{{ $message }}</div>@enderror
                </div>
            </div>

            <div class="row">
                <div class="col-md-6 mb-3">
                    <label class="form-label">Phone</label>
                    <input type="text" name="phone" class="form-control" value="{{ old('phone') }}" placeholder="Enter phone">
                </div>
                <div class="col-md-6 mb-3">
                    <label class="form-label">Qualification</label>
                    <input type="text" name="qualification" class="form-control" value="{{ old('qualification') }}" placeholder="e.g. M.Sc, B.Ed">
                </div>
            </div>

            <div class="row">
                <div class="col-md-6 mb-3">
                    <label class="form-label">Subject Specialization</label>
                    <input type="text" name="subject_specialization" class="form-control" value="{{ old('subject_specialization') }}" placeholder="e.g. Mathematics">
                </div>
                <div class="col-md-6 mb-3">
                    <label class="form-label">Experience</label>
                    <input type="text" name="experience" class="form-control" value="{{ old('experience') }}" placeholder="e.g. 5 years">
                </div>
            </div>

            <div class="row">
                <div class="col-md-6 mb-3">
                    <label class="form-label">Profile Image</label>
                    <input type="file" name="image" class="form-control" accept="image/*">
                </div>
                <div class="col-md-6 mb-3">
                    <label class="form-label">Status <span class="text-danger">*</span></label>
                    <select name="status" class="form-select" required>
                        <option value="active" {{ old('status') == 'active' ? 'selected' : '' }}>Active</option>
                        <option value="inactive" {{ old('status') == 'inactive' ? 'selected' : '' }}>Inactive</option>
                    </select>
                </div>
            </div>

            <div class="d-flex gap-3 mt-4">
                <button type="submit" class="btn-submit"><i class="fas fa-save"></i> Save Teacher</button>
                <a href="{{ route('students.index') }}" class="btn-back"><i class="fas fa-arrow-left"></i> Back</a>
            </div>
        </form>
    </div>
</div>
@endsection