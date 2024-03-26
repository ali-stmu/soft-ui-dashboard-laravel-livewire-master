<?php


namespace App\Http\Livewire;

namespace App\Http\Livewire;
use Illuminate\Support\Facades\Auth;

use App\Models\Faculty; // Assuming your model is named Faculty
use Livewire\Component;

class AddFaculty extends Component
{
    public $name;
    public $location;

    protected $rules = [
        'name' => 'required|string|max:255',
        'location' => 'nullable|string|max:255',
    ];

    public function save()
    {
        $this->validate();
        // Create a new faculty record
        Faculty::create([
            'name' => $this->name,
            'location' => $this->location,
            'created_by_id' => Auth::id(),
        ]);

        // Reset input fields after saving
        $this->reset(['name', 'location']);

        // Dispatch an event or add any other necessary logic

        // Optionally, you can add a message to indicate successful save
        session()->flash('message', 'Faculty added successfully!');
    }

    public function render()
    {
        // Fetch all faculty records from the database
        $faculties = Faculty::all();

        return view('livewire.add-faculty', [
            'faculties' => $faculties,
        ]);
    }
}
