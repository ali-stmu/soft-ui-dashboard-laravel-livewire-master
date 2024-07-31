<?php
namespace App\Mail;

use App\Models\ApprovalRequest;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class ApprovalRequestAlert extends Mailable
{
    use Queueable, SerializesModels;

    public $approvalRequest;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct(ApprovalRequest $approvalRequest)
    {
        $this->approvalRequest = $approvalRequest;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->subject('Approval Request Alert')
                    ->view('emails.approval_request_alert')
                    ->with([
                        'approvalRequest' => $this->approvalRequest,
                    ]);
    }
}
