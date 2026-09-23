{{--
    ============================================
    BEFORE (OLD CODE):
    ============================================
    - Simple student info box
    - No attachment section

    ============================================
    AFTER (NEW CODE — WITH ATTACHMENT INFO):
    ============================================
    - NEW: Attachment section
    - NEW: List of attached files
    ============================================
--}}

<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>New Student Added</title>
    <style>
        body { font-family: Arial, sans-serif; background: #f4f4f4; padding: 20px; }
        .container {
            max-width: 600px;
            margin: 0 auto;
            background: white;
            border-radius: 10px;
            overflow: hidden;
            box-shadow: 0 5px 20px rgba(0,0,0,0.1);
        }
        .header {
            background: linear-gradient(135deg, #1a1a2e, #16213e);
            color: white;
            padding: 30px;
            text-align: center;
        }
        .header h1 { margin: 0; color: #f5c842; }
        .body { padding: 30px; }
        .body h2 { color: #1a1a2e; }
        .body p { color: #555; line-height: 1.6; }
        .info-box {
            background: #f8f9fc;
            border-left: 4px solid #f5c842;
            padding: 15px;
            border-radius: 8px;
            margin: 15px 0;
        }
        .info-box strong { color: #1a1a2e; }

        /* NEW: Attachment box */
        .attachment-box {
            background: #fff3cd;
            border-left: 4px solid #ffc107;
            padding: 15px;
            border-radius: 8px;
            margin: 20px 0;
        }
        .attachment-box h4 { color: #856404; margin: 0 0 10px; }
        .attachment-box ul { margin: 0; padding-left: 20px; }
        .attachment-box li { color: #856404; margin-bottom: 5px; }

        .footer {
            background: #1a1a2e;
            color: #aaa;
            padding: 20px;
            text-align: center;
            font-size: 13px;
        }
    </style>
</head>
<body>

    <div class="container">
        <div class="header">
            <h1>🎓 New Student Added</h1>
        </div>

        <div class="body">
            <h2>Hello Admin,</h2>
            <p>A new student has been added to the system.</p>

            <div class="info-box">
                <p><strong>Name:</strong> {{ $student->name }}</p>
                <p><strong>Email:</strong> {{ $student->email }}</p>
                <p><strong>Age:</strong> {{ $student->age }}</p>
                <p><strong>Gender:</strong> {{ $student->gender == 'm' ? 'Male' : 'Female' }}</p>
                <p><strong>Status:</strong> {{ ucfirst($student->status) }}</p>
            </div>

            {{-- NEW: Attachment Info Section --}}
            <div class="attachment-box">
                <h4>📎 Attachments</h4>
                <ul>
                    @if($student->image)
                        <li>Student Photo: <strong>student-photo-{{ $student->id }}.jpg</strong></li>
                    @endif
                    <li>Student Report: <strong>student-report-{{ $student->id }}.pdf</strong> (if generated)</li>
                </ul>
            </div>

            <p>Please login to view the full details.</p>
        </div>

        <div class="footer">
            &copy; {{ date('Y') }} Student Management System. All Rights Reserved.
        </div>
    </div>

</body>
</html>