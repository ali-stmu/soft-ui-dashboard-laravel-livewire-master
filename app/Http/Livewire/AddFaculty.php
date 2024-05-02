<?php

namespace App\Http\Livewire;

use Illuminate\Support\Facades\Auth;
use Livewire\Component;
use App\Models\Faculty;

class AddFaculty extends Component
{
    public $name;
    public $location;
    public $faculties;
    public $editingFacultyId = null;

    protected $rules = [
        'name' => 'required|string|max:255',
        'location' => 'required|string|max:255',
    ];

    public function save()
    {
        $this->validate();

        if ($this->editingFacultyId) {
            $this->update();
        } else {
            $this->create();
        }

        $this->resetForm();
        $this->loadFaculty();
    }

    public function create()
    {
        // Create a new faculty record
        Faculty::create([
            'name' => $this->name,
            'location' => $this->location,
            'created_by_id' => Auth::id(),
        ]);
    }

    public function mount()
    {
        // Fetch all faculty records from the database during component initialization
        $this->loadFaculty();
    }

    public function loadFaculty()
    {
        // Load faculty records from the database and assign them to the faculties property
        $this->faculties = Faculty::all();
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

        // Update the faculty record
        $faculty = Faculty::findOrFail($this->editingFacultyId);
        $faculty->update([
            'name' => $this->name,
            'location' => $this->location,
        ]);

        $this->resetForm();
    }

    public function delete($facultyId)
    {
        // Delete the faculty record
        Faculty::findOrFail($facultyId)->delete();

        // Optionally, you can add a message to indicate successful deletion
        session()->flash('message', 'Faculty deleted successfully!');

        $this->loadFaculty();
    }

    public function render()
    {
        // Fetch all faculty records from the database

        return view('livewire.add-faculty');
    }

    private function resetForm()
    {
        $this->name = '';
        $this->location = '';
    }
}
