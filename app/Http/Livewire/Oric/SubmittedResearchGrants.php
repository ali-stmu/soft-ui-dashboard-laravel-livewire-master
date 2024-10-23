<?php

namespace App\Http\Livewire\Oric;

use Livewire\Component;
use Livewire\WithPagination; // Import the pagination trait
use App\Models\OricFormModal;
use App\Models\Remark;
use Illuminate\Support\Facades\Auth;

class SubmittedResearchGrants extends Component
{
    use WithPagination; // Use the pagination trait

    public $search = ''; // Search query
    public $selectedFormId = null;
    public $remarks = [];
    protected $listeners = ['loadFormData' => 'loadFormData'];
    protected $paginationTheme = 'bootstrap'; // Use Bootstrap styles for pagination

    public function updatingSearch()
    {
        // Reset pagination when search is updated
        $this->resetPage();
    }

    public function mount()
    {
        // No need to fetch records here; will be done in the render method
    }

    public function loadFormData($formId)
    {
        $this->emitTo('oric.edit-oric-form', 'loadFormData', $formId);
    }

    public function editForm($formId)
    {
        return redirect()->route('oric-form', ['formId' => $formId]);
    }

    public function viewForm($formId)
    {
        return redirect()->route('research-grants.index', ['formId' => $formId]);
    }

    public function loadRemarks($formId)
    {
        $this->remarks = Remark::where('form_id', $formId)->get();
        $this->dispatchBrowserEvent('showRemarksModal');
    }

    public function render()
    {
        // Fetch records for the authenticated user with search functionality
        $oricForms = OricFormModal::where('user_id', Auth::id())
            ->where('project_title', 'like', '%' . $this->search . '%')
            ->paginate(10); // Adjust pagination size if needed

        return view('livewire.oric.submitted-research-grants', [
            'oricForms' => $oricForms,
        ]);
    }
}
