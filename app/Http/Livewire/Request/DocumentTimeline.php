<?php

namespace App\Http\Livewire\Request;

use Livewire\Component;
use App\Models\ApprovalRequest;
use App\Models\Document;
use Illuminate\Support\Facades\Date; // Import Date class for better date formatting

class DocumentTimeline extends Component
{
    public $documentTimeline;
    private $processedDocumentIds = [];

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
    public function render()
    {
        return view('livewire.request.document-timeline');
    }
}
