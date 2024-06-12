<?php

namespace App\Http\Livewire\Request;

use App\Models\ApprovalRequest;
use App\Models\Document;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;
use App\Models\User; // Import User model
use App\Models\Department; // Import User model
use App\Models\Role; // Import User model
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Date; // Import Date class for better date formatting

class PendingRequest extends Component
{
    public $requestes;
    public $selectedRequestId = -1;
    public $remarks;
    public $rejectremarks;
    public $returnForwardDate;
    public $forwardwithsignreturnForwardDate;
    public $rejectreturnForwardDate;
    public $departments;
    public $roles;    
    public $departmentId;
    public $roleId;
    public $users = [];
    public $userId;
    public $documentRequests = [];
    public $documentTimeline = [];
    private $processedDocumentIds = [];
    public $receivingDates = []; // Add this line

    public function render()
    {
        return view('livewire.request.pending-request');
    }

    public function mount()
    {
        $this->requestes = ApprovalRequest::where('assigned_id', Auth::id())
        ->where('status', 'pending')
        ->get();   
        $this->departments = Department::all();
        $this->roles = Role::whereIn('name', ['Employee', 'PS/Coordinator'])->get();
        $this->users = User::where('role_id', $this->roleId)
        ->where('status', 'active')
        ->get();
        log::debug("in mount"); 
    }
    public function getAllApprovalRequests($requestId){
        $approvalRequests = ApprovalRequest::with('document')
            ->where('document_id', $requestId) // Add condition where id = $requestId
            ->orderBy('id', 'asc')    // Sort by ID in ascending order
            ->get();


        // Group by document ID and process documents only once
        $this->documentTimeline = $approvalRequests->groupBy(function ($request) {
            // Mark processed documents for efficiency
            if (!in_array($request->document_id, $this->processedDocumentIds)) {
                $this->processedDocumentIds[] = $request->document_id;
            }

            return $request->document_id;
        })->map(function ($requests) {
            // Access the first request to get document details (efficient)
            $firstRequest = $requests->first();
            return [
                'document' => [
                    'id' => $firstRequest->document->id,
                    'title' => $firstRequest->document->title,
                    'description' => $firstRequest->document->description,
                    'initiator' => $firstRequest->document->createdBy->name,
                    'created_at' => $firstRequest->document->created_at,
                ],
                'approvalRequests' => $requests->map(function ($request) {
                    return [
                        'id' => $request->id,
                        'assignedBy' => $request->assignedBy->name,
                        'assignedTo' => $request->assignedTo->name,
                        'status' => $request->status,
                        'signedDate' => Date::parse($request->signed_date)->format('Y-m-d'), // Format signed date for better display
                        'created_at' => $request->created_at, // Format signed date for better display
                    ];
                }),
            ];
        });


    }

    public function approveRequest($requestId)
    {
        $this->selectedRequestId = $requestId;
        $this->emit('showApproveModal'); // Emit event to show the modal

    }
    public function returnWithoutSignature($requestId)
    {
        $this->selectedRequestId = $requestId;
        $this->emit('showReturnWithoutSignatureModal'); // Emit event to show the modal

    }

    

    public function rejectRequest()
    {
        $request = ApprovalRequest::findOrFail($this->selectedRequestId);
    
        // Update the approval request
        $request->update([
            'remarks' => $this->rejectremarks,
            'signed_date' => $this->rejectreturnForwardDate,
            'status' => 'rejected',
        ]);
    
        // Reset variables
            $document = Document::where('id', $request->document_id)->first();
        if ($document) {
            $document->update([
                'approved_date' => $this->rejectreturnForwardDate,
                // You may need to adjust this based on your Document model structure
            ]);
        }
        $this->reset(['rejectremarks', 'rejectreturnForwardDate']);    
        // Close the modal
        $this->dispatchBrowserEvent('closeModal');
    }
    
    public function forwardRequest($requestId)
    {
        // Here you can perform any necessary actions before redirecting
        // For example, fetching additional data or processing some logic
        
        // Redirect to the ForwardWithSignature component
        return redirect()->route('forward-with-signature', ['requestId' => $requestId]);
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

public function saveReceivingDate($requestId)
{
    $request = ApprovalRequest::findOrFail($requestId);
    $request->update(['receiving_date' => $this->receivingDates[$requestId]]);
}

}
