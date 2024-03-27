<?php

// Livewire Component - AddDesignation.php
// Livewire Component - AddDesignation.php

namespace App\Http\Livewire;

use App\Models\Designation;
use Livewire\Component;
use Illuminate\Support\Facades\Auth;

class AddDesignation extends Component
{
    public $name;
    public $designationId; // For storing the ID of the designation being edited

    protected $rules = [
        'name' => 'required|string|max:255',
    ];

    public function render()
    {
        $designations = Designation::latest()->get(); // Fetch all designations
        return view('livewire.add-designation', compact('designations'));
    }

    public function save()
    {
        $this->validate();

        if ($this->designationId) {
            $designation = Designation::findOrFail($this->designationId);
            $designation->update([
                'name' => $this->name,
                'updated_by_id' => Auth::id(),
            ]);
        } else {
            Designation::create([
                'name' => $this->name,
                'created_by_id' => Auth::id(),
            ]);
        }

        $this->resetForm();
    }

    public function edit($id)
    {
        $designation = Designation::findOrFail($id);
        $this->name = $designation->name;
        $this->designationId = $designation->id;
    }

    public function delete($id)
    {
        $designation = Designation::findOrFail($id);
        $designation->delete();
    }

    private function resetForm()
    {
        $this->name = '';
        $this->designationId = null;
    }
}
