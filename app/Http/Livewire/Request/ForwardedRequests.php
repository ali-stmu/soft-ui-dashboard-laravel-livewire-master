<?php

namespace App\Http\Livewire\Request;
use App\Models\ApprovalRequest;
use Illuminate\Support\Facades\Auth;

use Livewire\Component;

class ForwardedRequests extends Component
{
    public function render()
    {
        return view('livewire.request.forwarded-requests');
    }

    public function mount()

    {
        $this->requestes = ApprovalRequest::where('assigned_id', Auth::id())
        ->where('status', 'finalapproved')
        ->get();    
    }
}
