<?php

namespace App\Http\Livewire\Request;

use App\Models\ApprovalRequest;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;

class CompletedRequest extends Component
{
    public $requestes;

    public function render()
    {
        return view('livewire.request.completed-request');
    }

    public function mount()
    {
        $this->requestes = ApprovalRequest::where('assigned_id', Auth::id())
        ->where('status', 'approved')
        ->get();    
    }
}
