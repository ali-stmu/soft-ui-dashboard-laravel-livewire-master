<?php

namespace App\Http\Livewire\Request;

use Livewire\Component;

class DocumentView extends Component
{
    public $document;

    public function showDocument($key)
    {
        $this->document = $documentTimeline[$key];
    }
    public function render()
    {
        return view('livewire.request.document-view');
    }
}
