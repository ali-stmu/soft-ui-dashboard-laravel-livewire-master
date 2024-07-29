<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class DispatcherNotification extends Mailable
{
    use Queueable, SerializesModels;

    public $document;
    public $dispatcher;
    public $creator;

    public function __construct($document, $dispatcher, $creator)
    {
        $this->document = $document;
        $this->dispatcher = $dispatcher;
        $this->creator = $creator;
    }

    public function build()
    {
        return $this->view('emails.dispatcher-notification')
                    ->subject('Document Dispatched')
                    ->with([
                        'document' => $this->document,
                        'dispatcher' => $this->dispatcher,
                        'creator' => $this->creator,
                    ]);
    }
}
