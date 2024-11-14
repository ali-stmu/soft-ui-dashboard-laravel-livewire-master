<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class OricSubmissionReturned extends Mailable
{
    use Queueable, SerializesModels;

    public $remarkTitle;
    public $initiatorName;
    public $formId;

    /**
     * Create a new message instance.
     *
     * @param string $remarkTitle
     * @param string $initiatorName
     * @param int $formId
     */
    public function __construct($remarkTitle, $initiatorName, $formId)
    {
        $this->remarkTitle = $remarkTitle;
        $this->initiatorName = $initiatorName;
        $this->formId = $formId;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->subject('ORIC Submission Returned')
                    ->view('emails.oric_submission_returned'); // Create this view file
    }
}
