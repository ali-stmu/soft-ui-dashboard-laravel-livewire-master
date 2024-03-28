<?php

namespace App\Http\Livewire;

use App\Models\Department;
use App\Models\Designation;
use App\Models\User;
use App\Models\Role;
use Livewire\Component;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\Rule; // Correct import for Rule class



class AddUser extends Component
{
    public $name;
    public $message;
    public $email;
    public $departmentId;
    public $designationId;
    public $userIdToEdit;
    public $roleId;
    public $designations;
    public $departments;
    public $roles;
    public $users;

    public function mount()
    {
        $this->departments = Department::all();
        $this->designations = Designation::all();
        $this->roles = Role::all();
        $this->users = User::orderByRaw("CASE WHEN status = 'active' THEN 1 ELSE 2 END")->get();
    }
    public function render()
    {

        return view('livewire.add-user');
    }
    public function saveUser()
    {
        // If userIdToEdit is set, call updateUser, else addUser
        if ($this->userIdToEdit) {
            $this->updateUser();
        } else {
            $this->addUser();
        }
    }

    public function addUser()
    {
        $this->validate([
            'name' => 'required|string',
            'email' => 'required|email|ends_with:stmu.edu.pk|unique:users,email',
            'departmentId' => 'required',
            'designationId' => 'required',
            'roleId' => 'required',
        ]);

        User::create([
            'name' => $this->name,
            'email' => $this->email,
            'department_id' => $this->departmentId,
            'designation_id' => $this->designationId,
            'role_id' => $this->roleId,
            'created_by_id' => Auth::id(),
        ]);

        // Clear input fields after submission
        $this->reset(['name', 'email', 'departmentId', 'designationId', 'roleId']);
        $this->message = 'User added successfully.';
        session()->flash('message', 'User added successfully.');
        $this->mount();
    }
    public function editUser($userId)
    {
        $user = User::findOrFail($userId);
        $this->userIdToEdit = $user->id;
        $this->name = $user->name;
        $this->email = $user->email;
        $this->departmentId = $user->department_id;
        $this->designationId = $user->designation_id;
        $this->roleId = $user->role_id;
    }

    public function updateUser()
    {
        $this->validate([
            'name' => 'required|string',
            'email' => ['required', 'email', Rule::unique('users', 'email')->ignore($this->userIdToEdit)],
            'departmentId' => 'required',
            'designationId' => 'required',
            'roleId' => 'required',
        ]);

        $user = User::findOrFail($this->userIdToEdit);
        $user->update([
            'name' => $this->name,
            'email' => $this->email,
            'department_id' => $this->departmentId,
            'designation_id' => $this->designationId,
            'role_id' => $this->roleId,
        ]);

        // Clear input fields after submission
        $this->reset(['name', 'email', 'departmentId', 'designationId', 'roleId', 'userIdToEdit']);
        $this->message = 'User updated successfully.';
        session()->flash('message', 'User updated successfully.');
        $this->mount();

    }

    public function disableUser($userId)
    {
        $user = User::findOrFail($userId);
        $user->update(['status' => 'inactive']);
        $this->message = 'User disabled successfully.';

        session()->flash('message', 'User disabled successfully.');
        $this->mount();

    }
    public function enableUser($userId)
    {
        $user = User::findOrFail($userId);
        $user->update(['status' => 'active']);
        $this->message = 'User enabled successfully.';

        session()->flash('message', 'User enabled successfully.');
        $this->mount();

    }
}
