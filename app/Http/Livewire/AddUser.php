<?php

namespace App\Http\Livewire;

use Livewire\WithPagination;
use App\Models\Department;
use App\Models\Designation;
use App\Models\User;
use App\Models\Role;
use Livewire\Component;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\DB;

class AddUser extends Component
{
    use WithPagination;

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
    public $searchTerm;

    protected $users;

    public function mount()
    {
        $this->departments = Department::all();
        $this->designations = Designation::all();
        $this->roles = Role::all();
    }

    public function updatingSearchTerm()
    {
        $this->resetPage();
    }

    public function render()
    {
        $searchTerm = '%' . $this->searchTerm . '%';

        $this->users = User::where(function($query) use ($searchTerm) {
                $query->where('name', 'like', $searchTerm)
                      ->orWhere('email', 'like', $searchTerm)
                      ->orWhereHas('department', function($q) use ($searchTerm) {
                          $q->where('name', 'like', $searchTerm);
                      })
                      ->orWhereHas('designation', function($q) use ($searchTerm) {
                          $q->where('name', 'like', $searchTerm);
                      })
                      ->orWhereHas('role', function($q) use ($searchTerm) {
                          $q->where('name', 'like', $searchTerm);
                      });
            })
            ->orderByRaw("CASE WHEN status = 'active' THEN 1 ELSE 2 END")
            ->paginate(5);

        return view('livewire.add-user', [
            'users' => $this->users,
        ]);
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
    
        $user = User::create([
            'name' => $this->name,
            'email' => $this->email,
            'department_id' => $this->departmentId,
            'designation_id' => $this->designationId,
            'role_id' => $this->roleId,
            'created_by_id' => Auth::id(),
        ]);
    
        // Get the department, designation, and role information
        $department = Department::find($this->departmentId);
        $designation = Designation::find($this->designationId);
        $role = Role::find($this->roleId);
    
        // Send welcome email
        \Mail::to($user->email)->send(new \App\Mail\WelcomeUserMail($user, $department, $designation, $role));
    
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
        $changes = [];

        // Check for changes and store old and new values
        if ($user->name !== $this->name) {
            $changes['name'] = ['old' => $user->name, 'new' => $this->name];
        }
        if ($user->email !== $this->email) {
            $changes['email'] = ['old' => $user->email, 'new' => $this->email];
        }
        if ($user->department_id !== $this->departmentId) {
            $changes['department'] = ['old' => Department::find($user->department_id)->name, 'new' => Department::find($this->departmentId)->name];
        }
        if ($user->designation_id !== $this->designationId) {
            $changes['designation'] = ['old' => Designation::find($user->designation_id)->name, 'new' => Designation::find($this->designationId)->name];
        }
        if ($user->role_id !== $this->roleId) {
            $changes['role'] = ['old' => Role::find($user->role_id)->name, 'new' => Role::find($this->roleId)->name];
        }

        $user->update([
            'name' => $this->name,
            'email' => $this->email,
            'department_id' => $this->departmentId,
            'designation_id' => $this->designationId,
            'role_id' => $this->roleId,
        ]);

        // Send edit notification email
        \Mail::to($user->email)->send(new \App\Mail\UserEditNotification($user, $changes));

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

        // Send disable notification email
        \Mail::to($user->email)->send(new \App\Mail\UserDisableNotification($user));

        session()->flash('message', 'User disabled successfully.');
        
        // Emit event to refresh page
        $this->emit('userStatusChanged');
    }

    public function enableUser($userId)
    {
        $user = User::findOrFail($userId);
        $user->update(['status' => 'active']);
        $this->message = 'User enabled successfully.';

        // Send enable notification email
        \Mail::to($user->email)->send(new \App\Mail\UserEnableNotification($user));

        session()->flash('message', 'User enabled successfully.');

        // Emit event to refresh page
        $this->emit('userStatusChanged');
    }
}
