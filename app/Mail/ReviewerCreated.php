<?php

namespace App\Mail;

use App\Models\Reviewer;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class ReviewerCreated extends Mailable
{
    use Queueable, SerializesModels;

    public $reviewer;
    public $password; // Add a property for the password

    /**
     * Create a new message instance.
     *
     * @param Reviewer $reviewer
     * @param string $password
     */
    public function __construct(Reviewer $reviewer, string $password)
    {
        $this->reviewer = $reviewer;
        $this->password = $password; // Store the password
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->view('emails.reviewer_created') // Create a view for this email
                    ->subject('Reviewer Account Created')
                    ->with([
                        'name' => $this->reviewer->name,
                        'email' => $this->reviewer->email,
                        'password' => $this->password, // Include the password in the email data
                    ]);
    }
}
