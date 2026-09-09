<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Student</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <style>
        * { margin: 0; padding: 0; box-sizing: border-box; }
        body { font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif; background: #f0f2f5; }
        .header {
            background: linear-gradient(135deg, #1a1a2e, #16213e);
            color: white;
            padding: 20px 0;
            box-shadow: 0 2px 15px rgba(0,0,0,0.3);
        }
        .header h1 { font-size: 28px; font-weight: 700; letter-spacing: 1px; }
        .header h1 span { color: #f5c842; }
        .header .subtitle { font-size: 14px; color: #aaa; }
        .nav-bar {
            background: #16213e;
            padding: 12px 0;
            border-bottom: 3px solid #f5c842;
        }
        .nav-bar a {
            color: white;
            text-decoration: none;
            padding: 8px 20px;
            font-weight: 500;
            transition: 0.3s;
            border-radius: 5px;
        }
        .nav-bar a:hover { background: #f5c842; color: #1a1a2e; }
        .nav-bar a.active { background: #f5c842; color: #1a1a2e; }
        .container-custom { max-width: 800px; margin: 40px auto; padding: 0 20px; }
        .form-card {
            background: white;
            border-radius: 15px;
            padding: 35px;
            box-shadow: 0 5px 30px rgba(0,0,0,0.1);
        }
        .form-card h2 {
            color: #1a1a2e;
            font-weight: 700;
            margin-bottom: 10px;
            border-bottom: 3px solid #f5c842;
            padding-bottom: 15px;
        }
        .form-card .subtitle { color: #666; margin-bottom: 25px; font-size: 14px; }
        .form-label { font-weight: 600; color: #1a1a2e; }
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
        .form-control.is-invalid, .form-select.is-invalid {
            border-color: #e74a3b;
            box-shadow: 0 0 0 3px rgba(231, 74, 59, 0.2);
        }
        .invalid-feedback { color: #e74a3b; font-size: 13px; margin-top: 5px; }
        .btn-submit {
            background: #1a1a2e;
            color: white;
            padding: 14px 40px;
            border: none;
            border-radius: 8px;
            font-weight: 600;
            font-size: 16px;
            transition: 0.3s;
        }
        .btn-submit:hover {
            background: #f5c842;
            color: #1a1a2e;
            transform: translateY(-2px);
            box-shadow: 0 5px 20px rgba(245, 200, 66, 0.4);
        }
        .btn-back {
            background: #6c757d;
            color: white;
            padding: 14px 30px;
            border: none;
            border-radius: 8px;
            font-weight: 600;
            text-decoration: none;
            transition: 0.3s;
        }
        .btn-back:hover { background: #5a6268; color: white; }
        .alert-danger { border-radius: 8px; border-left: 5px solid #e74a3b; }
        .footer {
            background: #1a1a2e;
            color: white;
            text-align: center;
            padding: 25px 0;
            margin-top: 40px;
        }
        .footer a { color: #f5c842; text-decoration: none; }
        .text-danger { font-size: 12px; margin-top: 5px; }
        .text-muted { font-size: 12px; color: #6c757d; }
        .current-image { width: 80px; height: 80px; object-fit: cover; border-radius: 10px; border: 2px solid #ddd; }
    </style>
</head>
<body>

    <!-- Header -->
    <div class="header">
        <div class="container">
            <div class="row align-items-center">
                <div class="col-md-8">
                    <h1>Student <span>Management</span> System</h1>
                    <div class="subtitle">Edit Student</div>
                </div>
                <div class="col-md-4 text-end">
                    <i class="fas fa-user-edit" style="font-size: 50px; opacity: 0.3;"></i>
                </div>
            </div>
        </div>
    </div>

    <!-- Navigation -->
    <div class="nav-bar">
        <div class="container">
            <a href="{{ route('students.index') }}"><i class="fas fa-home"></i> Dashboard</a>
            <a href="#" class="active"><i class="fas fa-user-edit"></i> Edit Student</a>
        </div>
    </div>

    <!-- Main Content -->
    <div class="container-custom">
        <div class="form-card">
            <h2><i class="fas fa-user-edit"></i> Edit Student</h2>
            <p class="subtitle">Update the details below to edit the student.</p>

            @if($errors->any())
                <div class="alert alert-danger">
                    <ul class="mb-0">
                        @foreach($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <form action="{{ route('students.update', $student->id) }}" method="POST" enctype="multipart/form-data">
                @csrf
                @method('PUT')

                <div class="row">
                    <div class="col-md-6 mb-3">
                        <label class="form-label">Full Name <span class="text-danger">*</span></label>
                        <input type="text" name="name" class="form-control @error('name') is-invalid @enderror" 
                               value="{{ old('name', $student->name) }}" required>
                        @error('name')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="col-md-6 mb-3">
                        <label class="form-label">Email Address <span class="text-danger">*</span></label>
                        <input type="email" name="email" class="form-control @error('email') is-invalid @enderror" 
                               value="{{ old('email', $student->email) }}" required>
                        @error('email')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                </div>

                <div class="row">
                    <div class="col-md-6 mb-3">
                        <label class="form-label">Age <span class="text-danger">*</span></label>
                        <input type="number" name="age" class="form-control @error('age') is-invalid @enderror" 
                               value="{{ old('age', $student->age) }}" required>
                        @error('age')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="col-md-6 mb-3">
                        <label class="form-label">Date of Birth <span class="text-danger">*</span></label>
                        <input type="date" name="date_of_birth" class="form-control @error('date_of_birth') is-invalid @enderror" 
                               value="{{ old('date_of_birth', $student->date_of_birth) }}" required>
                        @error('date_of_birth')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                </div>

                <div class="row">
                    <div class="col-md-6 mb-3">
                        <label class="form-label">Gender <span class="text-danger">*</span></label>
                        <select name="gender" class="form-select @error('gender') is-invalid @enderror" required>
                            <option value="m" {{ old('gender', $student->gender) == 'm' ? 'selected' : '' }}>Male</option>
                            <option value="f" {{ old('gender', $student->gender) == 'f' ? 'selected' : '' }}>Female</option>
                        </select>
                        @error('gender')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="col-md-6 mb-3">
                        <label class="form-label">Score</label>
                        <input type="number" name="score" class="form-control @error('score') is-invalid @enderror" 
                               value="{{ old('score', $student->score) }}" placeholder="Enter score (0-100)">
                        @error('score')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                </div>

                <div class="mb-3">
                    <label class="form-label">Status <span class="text-danger">*</span></label>
                    <select name="status" class="form-select @error('status') is-invalid @enderror" required>
                        <option value="active" {{ old('status', $student->status) == 'active' ? 'selected' : '' }}>Active</option>
                        <option value="inactive" {{ old('status', $student->status) == 'inactive' ? 'selected' : '' }}>Inactive</option>
                        <option value="pending" {{ old('status', $student->status) == 'pending' ? 'selected' : '' }}>Pending</option>
                    </select>
                    @error('status')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <!-- ✅ Image Upload -->
                <div class="mb-3">
                    <label class="form-label">Profile Image</label>
                    
                    @if($student->image)
                        <div class="mb-2">
                            <img src="{{ asset('storage/' . $student->image) }}" alt="Student Image" class="current-image">
                        </div>
                    @else
                        <div class="mb-2">
                            <div style="width: 80px; height: 80px; background: #ddd; border-radius: 10px; display: flex; align-items: center; justify-content: center; border: 2px solid #ddd;">
                                <i class="fas fa-user" style="font-size: 30px; color: #999;"></i>
                            </div>
                        </div>
                    @endif

                    <input type="file" name="image" class="form-control @error('image') is-invalid @enderror" accept="image/*">
                    @error('image')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                    <small class="text-muted">Allowed: jpeg, png, jpg, gif | Max: 2MB</small>
                </div>

                <div class="d-flex gap-3 mt-4">
                    <button type="submit" class="btn-submit"><i class="fas fa-save"></i> Update Student</button>
                    <a href="{{ route('students.index') }}" class="btn-back"><i class="fas fa-arrow-left"></i> Back to Dashboard</a>
                </div>
            </form>
        </div>
    </div>

    <!-- Footer -->
    <div class="footer">
        <div class="container">
            <p>&copy; 2026 Student Management System. All Rights Reserved.</p>
            <p>
                <a href="#">About Us</a> |
                <a href="#">Contact Us</a>
            </p>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>