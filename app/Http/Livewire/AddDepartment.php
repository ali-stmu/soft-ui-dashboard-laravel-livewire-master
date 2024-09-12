<?php

namespace App\Http\Livewire;

use Livewire\Component;
use Livewire\WithPagination; // Import the pagination trait
use App\Models\Faculty;
use App\Models\FacultyType;
use App\Models\Department;
use Illuminate\Support\Facades\Auth;

class AddDepartment extends Component
{
    use WithPagination; // Use pagination
    protected $paginationTheme = 'bootstrap'; // Optional, if you want Bootstrap-styled pagination

    public $name;
    public $type; // This will now store 'Academic' or 'Non-Academic'
    public $facultyId;
    public $facultyTypes;
    public $faculties;
    public $search = ''; // For search functionality
    public $departmentId; // Added for edit functionality

    // Number of records per page
    public $perPage = 5;

    protected $rules = [
        'name' => 'required',
        'type' => 'required|in:Academic,Non-Academic', // Validate type directly from the enum
        'facultyId' => 'required',
    ];
    

    public function mount()
    {
        $this->facultyTypes = FacultyType::all();
        $this->faculties = Faculty::all();
    }

    public function render()
    {
        $departments = Department::where('name', 'like', '%' . $this->search . '%')
            ->orWhereHas('faculty', function ($query) {
                $query->where('name', 'like', '%' . $this->search . '%');
            })
            ->paginate($this->perPage);

        return view('livewire.add-department', [
            'departments' => $departments,
        ]);
    }

    public function saveDepartment()
    {
        $this->validate();

        if ($this->departmentId) {
            $this->updateDepartment();
        } else {
            Department::create([
                'name' => $this->name,
                'type' => $this->type, // Store the type directly
                'faculty_id' => $this->facultyId,
                'created_by_id' => Auth::id(),
            ]);
            
        }

        $this->reset(['name', 'type', 'facultyId', 'departmentId']);
        $this->render();
    }

    public function edit($departmentId)
    {
        $department = Department::findOrFail($departmentId);
        $this->name = $department->name;
        $this->type = $department->type;
        $this->facultyId = $department->faculty_id;
        $this->departmentId = $departmentId;
    }

    public function updateDepartment()
    {
        $this->validate();

        $department = Department::findOrFail($this->departmentId);
        $department->update([
            'name' => $this->name,
            'type' => $this->type,
            'faculty_id' => $this->facultyId,
            'created_by_id' => Auth::id(),
        ]);

        $this->reset(['name', 'type', 'facultyId', 'departmentId']);
        $this->render();
    }

    public function delete($departmentId)
    {
        Department::findOrFail($departmentId)->delete();
        $this->render();
    }
}
