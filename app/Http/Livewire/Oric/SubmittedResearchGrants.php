<?php

namespace App\Http\Livewire\Oric;

use Livewire\Component;
use App\Models\OricFormModal;
use Illuminate\Support\Facades\Auth;

class SubmittedResearchGrants extends Component
{
    public $oricForms;
    public $selectedFormId = null; // To track the selected form for editing
    protected $listeners = ['loadFormData' => 'loadFormData'];

    public function mount()
    {
        // Fetch the records for the authenticated user
        $this->oricForms = OricFormModal::where('user_id', Auth::id())->get();
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

    public function render()
    {
        return view('livewire.oric.submitted-research-grants', [
            'oricForms' => $this->oricForms,
        ]);
    }
}
