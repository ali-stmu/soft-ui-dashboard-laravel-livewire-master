<?php

namespace App\Http\Livewire\Oric;

use Livewire\Component;
use App\Models\OricFormModal;

class ShowResearchGrant extends Component
{
    public $researchGrant;

    public function mount($id)
    {
        // Fetch the specific research grant by its ID
        $this->researchGrant = OricFormModal::findOrFail($id);
    }

    public function render()
    {
        return view('livewire.oric.show-research-grant', [
            'researchGrant' => $this->researchGrant, // Pass the variable to the view
        ]);
    }
}
