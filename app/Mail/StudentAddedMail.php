<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;   // <-- Queue ke liye
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use App\Models\Student;

class StudentAddedMail extends Mailable implements ShouldQueue   // <-- ShouldQueue add kiya
{
    use Queueable, SerializesModels;

    public $student;

    /**
     * Create a new message instance.
     */
    public function __construct(Student $student)
    {
        $this->student = $student;
    }

    /**
     * Build the message.
     */
    public function build()
    {
        $mail = $this->subject('New Student Added: ' . $this->student->name)
                     ->view('emails.student-added');

        // Attach student photo (if exists)
        if ($this->student->image) {
            $imagePath = public_path('storage/' . $this->student->image);
            if (file_exists($imagePath)) {
                $mail->attach($imagePath, [
                    'as' => 'student-photo-' . $this->student->id . '.jpg',
                    'mime' => 'image/jpeg',
                ]);
            }
        }

        // Attach PDF report (if exists)
        $pdfPath = storage_path('app/reports/student-' . $this->student->id . '.pdf');
        if (file_exists($pdfPath)) {
            $mail->attach($pdfPath, [
                'as' => 'student-report-' . $this->student->id . '.pdf',
                'mime' => 'application/pdf',
            ]);
        }

        return $mail;
    }
}