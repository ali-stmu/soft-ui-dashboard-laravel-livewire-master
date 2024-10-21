<?php

namespace App\Http\Livewire\Oric;

use Livewire\Component;
use App\Models\OricFormModal;
use App\Models\Remark;
use Illuminate\Support\Facades\Auth;

class ViewResearchGrants extends Component
{
    public $oricForms;
    public $remarksTitle; // For the remarks input
    public $selectedFormId; // To store the selected ORIC form ID
    public $selectedUserId; // To store the selected user ID


    public function mount()
    {
        // Fetch all records from the OricFormModal table
        $this->oricForms = OricFormModal::all();
    }
    public function submitRemark()
    {
        \Log::info('Submit Remark called', [
            'remarksTitle' => $this->remarksTitle,
            'selectedUserId' => $this->selectedUserId,
            'selectedFormId' => $this->selectedFormId,
        ]);
    
        // Validate the input
        $this->validate([
            'remarksTitle' => 'required|string',
            'selectedUserId' => 'required',
            'selectedFormId' => 'required',
        ]);
    
        try {
            // Check if a remark already exists for the selected form
            $remark = Remark::where('form_id', $this->selectedFormId)->first();
    
            if ($remark) {
                // Update the existing remark
                $remark->update([
                    'title' => $this->remarksTitle,
                    'director_id' => Auth::id(), // Optional: Only if the director changes
                ]);
            } else {
                // Create a new remark
                Remark::create([
                    'title' => $this->remarksTitle,
                    'director_id' => Auth::id(),
                    'initiator_id' => $this->selectedUserId,
                    'form_id' => $this->selectedFormId,
                ]);
            }
    
            // Reset fields
            $this->reset('remarksTitle', 'selectedUserId', 'selectedFormId');
    
            // Show a success message
            session()->flash('message', 'Remark saved successfully!');
    
            // Trigger a page refresh using Livewire's JavaScript
            $this->dispatchBrowserEvent('refresh-page');
    
        } catch (\Exception $e) {
            session()->flash('error', 'Failed to save remark: ' . $e->getMessage());
        }
    }
    
    
    public function render()
    {
        return view('livewire.oric.view-research-grants', [
            'oricForms' => $this->oricForms,
        ]);
    }
}
