<?php

namespace App\Listeners;

use App\Events\StudentAdded;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;
use App\Mail\StudentAddedMail;

class SendStudentNotification implements ShouldQueue
{
    use InteractsWithQueue;

    /**
     * Create the event listener.
     */
    public function __construct()
    {
        //
    }

    /**
     * Handle the event.
     */
    public function handle(StudentAdded $event)
    {
        // 1. Email bhejo (queued)
        Mail::to($event->student->email)->queue(new StudentAddedMail($event->student));

        // 2. Log likho
        Log::info('Student Added Event Fired', [
            'student_id'   => $event->student->id,
            'student_name' => $event->student->name,
            'time'         => now()->toDateTimeString(),
        ]);
    }
}