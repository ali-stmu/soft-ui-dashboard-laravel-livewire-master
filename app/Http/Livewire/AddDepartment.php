<?php

namespace App\Http\Livewire;

use Livewire\Component;
use App\Models\Faculty;
use App\Models\FacultyType;
use App\Models\Department;
use Illuminate\Support\Facades\Auth;

class AddDepartment extends Component
{
    public $name;
    public $typeId;
    public $facultyId;
    public $facultyTypes;
    public $faculties;
    public $Department;
    public $departmentId; // Added for edit functionality

    public function mount()
    {
        $this->facultyTypes = FacultyType::all();
        $this->faculties = Faculty::all();
        $this->loadDepartment();
    }

    public function render()
    {
        return view('livewire.add-department');
    }

    public function loadDepartment()
    {
        $this->Department = Department::all();
    }

    public function saveDepartment()
    {
        $this->validate([
            'name' => 'required',
            'typeId' => 'required',
            'facultyId' => 'required',
        ]);

        Department::create([
            'name' => $this->name,
            'type' => $this->typeId,
            'faculty_id' => $this->facultyId,
            'created_by_id' => Auth::id(),
        ]);

        // Reset input fields after saving
        $this->reset(['name', 'typeId', 'facultyId']);
        $this->loadDepartment(); // Reload department list after saving
    }

    // Edit department
    public function edit($departmentId)
    {
        $department = Department::findOrFail($departmentId);
        $this->name = $department->name;
        $this->typeId = $department->typeId;
        $this->facultyId = $department->faculty_id;
        $this->departmentId = $departmentId; // Store department id for updating
    }

    // Update department
    public function updateDepartment()
    {
        $this->validate([
            'name' => 'required',
            'typeId' => 'required',
            'facultyId' => 'required',
        ]);

        $department = Department::findOrFail($this->departmentId);
        $department->update([
            'name' => $this->name,
            'type_id' => $this->typeId,
            'faculty_id' => $this->facultyId,
            'created_by_id' => Auth::id(),
        ]);

        // Reset input fields after updating
        $this->reset(['name', 'typeId', 'facultyId', 'departmentId']);
        $this->loadDepartment(); // Reload department list after updating
    }

    // Delete department
    public function delete($departmentId)
    {
        Department::findOrFail($departmentId)->delete();
        $this->loadDepartment(); // Reload department list after deleting
    }
}
