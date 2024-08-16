<?php

namespace App\Http\Livewire;

use Illuminate\Support\Facades\Auth;
use Livewire\Component;
use Livewire\WithPagination;
use App\Models\Faculty;

class AddFaculty extends Component
{
    use WithPagination;

    public $name;
    public $location;
    public $search = '';  // Search query
    public $editingFacultyId = null;

    protected $rules = [
        'name' => 'required|string|max:255',
        'location' => 'required|string|max:255',
    ];

    public function updatingSearch()
    {
        $this->resetPage(); // Reset pagination when search changes
    }

    public function save()
    {
        $this->validate();

        if ($this->editingFacultyId) {
            $this->update();
        } else {
            $this->create();
        }

        $this->resetForm();
    }

    public function create()
    {
        Faculty::create([
            'name' => $this->name,
            'location' => $this->location,
            'created_by_id' => Auth::id(),
        ]);
    }

    public function edit($facultyId)
    {
        $faculty = Faculty::findOrFail($facultyId);
        $this->editingFacultyId = $faculty->id;
        $this->name = $faculty->name;
        $this->location = $faculty->location;
    }

    public function update()
    {
        $this->validate();

        $faculty = Faculty::findOrFail($this->editingFacultyId);
        $faculty->update([
            'name' => $this->name,
            'location' => $this->location,
        ]);

        $this->resetForm();
    }

    public function delete($facultyId)
    {
        Faculty::findOrFail($facultyId)->delete();

        session()->flash('message', 'Faculty deleted successfully!');
    }

    public function render()
    {
        $faculties = Faculty::where('name', 'like', '%' . $this->search . '%')
            ->orWhere('location', 'like', '%' . $this->search . '%')
            ->paginate(5);

        return view('livewire.add-faculty', [
            'faculties' => $faculties,
        ]);
    }

    private function resetForm()
    {
        $this->name = '';
        $this->location = '';
        $this->editingFacultyId = null;
    }
}
