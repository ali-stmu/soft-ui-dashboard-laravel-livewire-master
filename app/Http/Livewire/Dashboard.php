<?php

namespace App\Http\Livewire;

use Livewire\Component;
use App\Models\ApprovalRequest;
use Illuminate\Support\Facades\Auth;

class Dashboard extends Component
{
    public $pendingCount;
    public $myRequestsCount;
    public $completedCount;

    public function mount()
    {
        $this->loadCounts();
    }

    public function loadCounts()
    {
        $userId = Auth::id();

        // Count of pending requests assigned to the current user
        $this->pendingCount = ApprovalRequest::where('assigned_id', $userId)
            ->where('status', 'pending')
            ->count();

        // Count of all requests assigned to the current user
        $this->myRequestsCount = ApprovalRequest::where('assigned_id', $userId)->count();

        // Count of completed (finalapproved) requests
        $this->completedCount = ApprovalRequest::where(function($query) {
            $query->where('status', 'finalapproved')
                  ->orWhere('status', 'approved');
        })->where('assigned_id', $userId)->count();
        
    }

    public function render()
    {
        return view('livewire.dashboard');
    }
}
