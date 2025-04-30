<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class InterviewScheduleUpdated extends Mailable
{
    use SerializesModels;

    public $emailData;

    public function __construct($emailData)
    {
        $this->emailData = $emailData;
    }

    public function build()
    {
        // Format dates and times into the desired format
        $formattedDatesTimes = [];

        // Make sure both 'dates' and 'times' are aligned properly
        foreach ($this->emailData['dates'] as $key => $date) {
            // Handle the case where times might be missing for some dates
            $time = isset($this->emailData['times'][$key]) ? $this->emailData['times'][$key] : 'No Time Provided';
            $formattedDatesTimes[] = $date . ' - ' . $time;
        }

        return $this->subject('Interview Schedule Updated')
            ->view('emails.interview_schedule_updated')
            ->with([
                'applicant_name' => $this->emailData['applicant_name'],
                'dates_times' => implode('<br>', $formattedDatesTimes), // Join with line break for proper display in HTML
                'location' => $this->emailData['location'],
            ]);
    }
}
