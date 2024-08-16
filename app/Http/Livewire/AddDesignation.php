<?php

namespace App\Http\Livewire;

use App\Models\Designation;
use Livewire\Component;
use Livewire\WithPagination; // Import the pagination trait
use Illuminate\Support\Facades\Auth;

class AddDesignation extends Component
{
    use WithPagination; // Use pagination

    public $name;
    public $designationId;
    public $search = ''; // For search functionality

    protected $rules = [
        'name' => 'required|string|max:255',
    ];

    public function render()
    {
        $designations = Designation::where('name', 'like', '%' . $this->search . '%')
            ->latest()
            ->paginate(5); // Pagination with 5 items per page

        return view('livewire.add-designation', compact('designations'));
    }

    public function save()
    {
        $this->validate();

        if ($this->designationId) {
            $designation = Designation::findOrFail($this->designationId);
            $designation->update([
                'name' => $this->name,
                'created_by_id' => Auth::id(),
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
