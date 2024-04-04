<?php

namespace App\Http\Livewire\Request;

use App\Models\ApprovalRequest;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;

class PendingRequest extends Component
{
    public $requestes;
    public $selectedRequestId = -1;
    public $remarks;

    public function render()
    {
        return view('livewire.request.pending-request');
    }

    public function mount()
    {
        $this->requestes = ApprovalRequest::where('assigned_id', Auth::id())->get();
    }

    public function approveRequest($requestId)
    {
        $this->selectedRequestId = $requestId;
        $this->emit('showApproveModal'); // Emit event to show the modal

    }

    public function rejectRequest($requestId)
    {
        // Implement logic to reject the request
    }

    public function confirmApprove()
    {
        $request = ApprovalRequest::findOrFail($this->selectedRequestId);
        $request->update([
            'approved_date' => now(),
            'remarks' => $this->remarks,
        ]);
        // Reset variables
  
        $this->reset('remarks');
        $this->dispatchBrowserEvent('closeModal');
    }
}
