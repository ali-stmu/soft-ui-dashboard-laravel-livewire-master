<?php

namespace App\Mail;

use App\Models\OricFormModal;
use App\Models\Reviewer;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Auth;

class OricFormForwarded extends Mailable
{
    use Queueable, SerializesModels;

    public $formTitle;
    public $reviewerName;
    public $formId;
    public $directorName; // Add director's name

    /**
     * Create a new message instance.
     *
     * @param  string  $formTitle
     * @param  string  $reviewerName
     * @param  int  $formId
     * @return void
     */
    public function __construct($formTitle, $reviewerName, $formId)
    {
        $this->formTitle = $formTitle;
        $this->reviewerName = $reviewerName;
        $this->formId = $formId;
        $this->directorName = Auth::user()->name; // Get the authenticated user's name
    }

    /**
     * Build the message.
     *
     * @return \Illuminate\Mail\Mailable
     */
    public function build()
    {
        return $this->subject('New ORIC Form Assigned for Review')
                    ->view('emails.oricFormForwarded');
    }
}
