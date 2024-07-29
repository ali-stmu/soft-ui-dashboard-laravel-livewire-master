<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class DocumentAssignedNotification extends Mailable
{
    use Queueable, SerializesModels;

    public $document;
    public $user;
    public $creator;

    public function __construct($document, $user, $creator)
    {
        $this->document = $document;
        $this->user = $user;
        $this->creator = $creator;
    }

    public function build()
    {
        return $this->view('emails.document-assigned-notification')
                    ->subject('Document Assigned to You')
                    ->with([
                        'document' => $this->document,
                        'user' => $this->user,
                        'creator' => $this->creator,
                    ]);
    }
}
