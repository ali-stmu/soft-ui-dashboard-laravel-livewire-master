<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class UserEditNotification extends Mailable
{
    use Queueable, SerializesModels;

    public $user;
    public $changes;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($user, $changes)
    {
        $this->user = $user;
        $this->changes = $changes;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->view('emails.user-edit-notification')
                    ->subject('Your Account Information Has Been Updated')
                    ->with([
                        'user' => $this->user,
                        'changes' => $this->changes,
                        'university' => 'Shifa Tameer Millat University'
                    ]);
    }
}
