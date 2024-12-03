<?php

namespace App\Mail;

use App\Models\User;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class ReviewerCreated extends Mailable
{
    use Queueable, SerializesModels;

    public $user; // Change to reference the User model
    public $password; // Add a property for the password

    /**
     * Create a new message instance.
     *
     * @param User $user
     * @param string $password
     */
    public function __construct(User $user, string $password)
    {
        $this->user = $user; // Store the user instance
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
                        'name' => $this->user->name, // Use the User model's name
                        'email' => $this->user->email, // Use the User model's email
                        'password' => $this->password, // Include the password in the email data
                    ]);
    }
}
