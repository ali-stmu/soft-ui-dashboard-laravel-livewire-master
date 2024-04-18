<?php

namespace App\Http\Livewire\Request;

use App\Models\ApprovalRequest;
use App\Models\Document;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;

class PendingRequest extends Component
{
    public $requestes;
    public $selectedRequestId = -1;
    public $remarks;
    public $returnForwardDate;

    public function render()
    {
        return view('livewire.request.pending-request');
    }

    public function mount()
    {
        $this->requestes = ApprovalRequest::where('assigned_id', Auth::id())
        ->where('status', 'pending')
        ->get();    }

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

    // Update the approval request
    $request->update([
        'signed_date' => $this->returnForwardDate,
        'remarks' => $this->remarks,
        'status' => 'approved',
    ]);

    // Reset variables
   

    // Update the associated document
    $document = Document::where('id', $request->document_id)->first();
    if ($document) {
        $document->update([
            'approved_date' => $this->returnForwardDate,
            // You may need to adjust this based on your Document model structure
        ]);
    }
    $this->reset(['remarks', 'returnForwardDate']);

    // Close the modal
    $this->dispatchBrowserEvent('closeModal');
}

}
