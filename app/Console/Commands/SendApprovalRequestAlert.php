<?php

namespace App\Console\Commands;

use App\Models\ApprovalRequest;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Mail;
use App\Mail\ApprovalRequestAlert;
use Illuminate\Support\Facades\Log;

class SendApprovalRequestAlert extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'alert:approval-request';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Send alert emails for pending approval requests older than 3 days.';

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        // Fetch pending approval requests older than 3 days and without a sent alert
        $pendingRequests = ApprovalRequest::where('status', 'pending')
            ->where('created_at', '<', now()->subDays(3))
            ->whereNull('alert_sent_at')
            ->get();

        if ($pendingRequests->isEmpty()) {
            Log::info('No pending approval requests found to send alerts.');
            return Command::SUCCESS;
        }

        foreach ($pendingRequests as $approvalRequest) {
            try {
                // Send email to the assigned user
                Mail::to($approvalRequest->assignedTo->email)
                    ->send(new ApprovalRequestAlert($approvalRequest));

                // Update the alert_sent_at timestamp
                $approvalRequest->update(['alert_sent_at' => now()]);

                Log::info('Sent alert for approval request ID: ' . $approvalRequest->id);
            } catch (\Exception $e) {
                Log::error('Failed to send alert for approval request ID: ' . $approvalRequest->id . ' - Error: ' . $e->getMessage());
            }
        }

        return Command::SUCCESS;
    }
}
