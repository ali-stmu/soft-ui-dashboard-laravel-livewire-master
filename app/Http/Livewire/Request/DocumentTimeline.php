<?php

namespace App\Http\Livewire\Request;

use Livewire\Component;
use App\Models\ApprovalRequest;
use App\Models\Document;

class DocumentTimeline extends Component
{
    public $documentTimeline;
    private $processedDocumentIds = []; // Track processed documents for efficiency

    public function mount()
    {
        // Fetch approval requests with eager loading (optimized)
        $approvalRequests = ApprovalRequest::with('document')
            ->orderBy('id', 'asc') // Sort by ID in ascending order
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
                ],
                'approvalRequests' => $requests->map(function ($request) {
                    return [
                        'id' => $request->id,
                        'assignedBy' => $request->assignedBy->name,
                        'assignedTo' => $request->assignedTo->name,
                        'status' => $request->status,
                        'signedDate' => $request->signed_date,
                    ];
                }),
            ];
        });
    }
    

    public function render()
    {
        return view('livewire.request.document-timeline');
    }
}

