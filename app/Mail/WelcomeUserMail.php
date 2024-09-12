<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class WelcomeUserMail extends Mailable
{
    use Queueable, SerializesModels;

    public $user;
    public $department;
    public $designation;
    public $role;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($user, $department, $designation, $role)
    {
        $this->user = $user;
        $this->department = $department;
        $this->designation = $designation;
        $this->role = $role;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->view('emails.welcome-user')
                    ->subject('Welcome to Diary Management System')
                    ->with([
                        'user' => $this->user,
                        'department' => $this->department,
                        'designation' => $this->designation,
                        'role' => $this->role,
                        'university' => 'Shifa Tameer Millat University',
                    ])
                    ->attach(public_path('storage/attachments/Diary Management System Document.pdf'), [
                        'as' => 'Diary Management System Document.pdf',
                        'mime' => 'application/pdf',
                    ]);
    }
}
