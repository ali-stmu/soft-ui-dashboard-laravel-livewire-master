<?php

namespace App\Http\Livewire\Oric;

use Livewire\Component;
use App\Models\Forward;
use Illuminate\Support\Facades\Auth;

class ReviewerEvaluationForms extends Component
{
    public $search = '';  // Search term
    public $perPage = 10; // Number of items per page
    private $assignedForms; // Private property for assigned forms

    public function mount()
    {
        $this->loadAssignedForms();
    }

    public function updatedSearch()
    {
        $this->loadAssignedForms();
    }

    public function loadAssignedForms()
    {
        $this->assignedForms = Forward::with('form')
            ->where('reviewer_id', Auth::id())  // filter by the authenticated user
            ->whereHas('form', function($query) {
                $query->where('project_title', 'like', '%' . $this->search . '%')
                      ->orWhere('pi_name', 'like', '%' . $this->search . '%')
                      ->orWhere('pi_email', 'like', '%' . $this->search . '%');
            })
            ->paginate($this->perPage);
    }

    // This method exposes the assigned forms data to the view
    public function getAssignedForms()
    {
        return $this->assignedForms;
    }

    public function render()
    {
        return view('livewire.oric.reviewer-evaluation-forms', [
            'assignedForms' => $this->getAssignedForms(),
        ]);
    }
}
