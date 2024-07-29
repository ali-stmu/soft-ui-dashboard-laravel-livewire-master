<?php

// app/Console/Commands/SendApprovalRequestAlert.php

use App\Models\ApprovalRequest;
use Illuminate\Support\Facades\Mail;
use App\Mail\ApprovalRequestAlert;

// Fetch pending approval requests older than 3 days
$pendingRequests = ApprovalRequest::where('status', 'pending')
    ->where('created_at', '<', now()->subDays(3))
    ->get();

foreach ($pendingRequests as $approvalRequest) {
    // Send email to the assigned user
    Mail::to($approvalRequest->assignedTo->email)
        ->send(new ApprovalRequestAlert($approvalRequest));
}
