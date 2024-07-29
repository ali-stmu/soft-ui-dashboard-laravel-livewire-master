<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class DocumentCreatedNotification extends Mailable
{
    use Queueable, SerializesModels;

    public $document;
    public $user;

    public function __construct($document, $user)
    {
        $this->document = $document;
        $this->user = $user;
    }

    public function build()
    {
        return $this->view('emails.document-created-notification')
                    ->subject('Document Created')
                    ->with([
                        'document' => $this->document,
                        'user' => $this->user,
                    ]);
    }
}
