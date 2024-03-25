<?php

namespace App\Http\Livewire\Request;

use Livewire\Component;
use App\Models\Document;
use Illuminate\Support\Facades\Auth;
use Livewire\WithFileUploads;

class MyRequest extends Component
{
    use WithFileUploads;

    public $title;
    public $description;
    public $attachment;
    public $dispatch_date;
    public $approved_date;

    protected $rules = [
        'title' => 'required|string',
        'description' => 'required|string',
        'attachment' => 'nullable|image|max:1024', // Assuming attachment is an image
        'dispatch_date' => 'required|date',
        'approved_date' => 'nullable|date',
    ];

    public function save()
    {
        $validatedData = $this->validate();

        $validatedData['user_id'] = Auth::id();

        if ($this->attachment) {
            $validatedData['attachment'] = $this->attachment->store('attachments');
        }

        $document = Document::create($validatedData);
        

        $this->reset();
        session()->flash('message', 'Request saved successfully.');
    }
    public function render()
    {
        return view('livewire.request.my-request');
    }
}
