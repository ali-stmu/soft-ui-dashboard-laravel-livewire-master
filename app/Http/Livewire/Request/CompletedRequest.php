<?php

namespace App\Http\Livewire\Request;

use App\Models\ApprovalRequest;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;
use Livewire\WithPagination;

class CompletedRequest extends Component
{
    use WithPagination;

    public $searchTerm;
    protected $paginationTheme = 'bootstrap'; // Optional, if you want Bootstrap-styled pagination

    public function render()
    {
        $searchTerm = '%' . $this->searchTerm . '%';

        $requestes = ApprovalRequest::where('assigned_id', Auth::id())
            ->where('status', 'approved')
            ->whereHas('document', function ($query) use ($searchTerm) {
                $query->where('title', 'like', $searchTerm)
                      ->orWhere('description', 'like', $searchTerm);
            })
            ->paginate(10); // 10 items per page

        return view('livewire.request.completed-request', [
            'requestes' => $requestes
        ]);
    }
}
