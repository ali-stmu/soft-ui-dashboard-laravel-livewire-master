<?php

namespace App\Http\Livewire\Request;

use Livewire\Component;
use App\Models\Document;
use App\Models\ApprovalRequest;
use App\Models\User; // Import User model
use App\Models\Department; // Import User model
use App\Models\Role; // Import User model
use Illuminate\Support\Facades\Auth;
use Livewire\WithFileUploads;
use Illuminate\Support\Facades\Storage;

class MyRequest extends Component
{
    use WithFileUploads;

    public $title;
    public $description;
    public $attachment;
    public $dispatch_date;
    public $approved_date;
    public $dispatcher_id; // Add dispatcher_id property
    public $dispatchers; // Property to store dispatchers
    public $documents;
    public $departments;
    public $roles;    
    public $departmentId;
    public $roleId;
    public $users = [];
    public $userId;

    protected $rules = [
        'title' => 'required|string',
        'description' => 'nullable|string',
        'attachment' => 'nullable|mimes:jpeg,png,gif,pdf|max:10240', // Allow jpeg, png, gif, and pdf file types up to 10MB
        'dispatch_date' => 'required|date',
        'approved_date' => 'nullable|date',
        'dispatcher_id' => 'required', // Add validation rule for dispatcher_id
    ];
    public function updatedRoleId($value)
    {
        // This method will automatically be called whenever $roleId is updated
        // Fetch users based on the selected role
        $this->users = User::where('role_id', $value)
                           ->where('department_id', $this->departmentId)
                           ->where('status', 'active')
                           ->get();
    }

    public function updatedDepartmentId($value)
    {
        // This method will automatically be called whenever $roleId is updated
        // Fetch users based on the selected role
        $this->users = User::where('role_id', $this->roleId)
                           ->where('department_id', $value)
                           ->where('status', 'active')
                           ->get();
    }
    
    public function mount()
    {
        // Fetch dispatchers from the database
        $this->dispatchers = User::whereHas('role', function ($query) {
                                $query->where('name', 'Dispatcher');
                            })->pluck('name', 'id');
        $this->documents = Document::where('created_by_id', auth()->id())->get(); 

        $this->departments = Department::all();
        $this->roles = Role::whereIn('name', ['Employee', 'PS/Coordinator'])->get();
        $this->users = User::where('role_id', $this->roleId)
        ->where('status', 'active')
        ->get();

    }

    public function save()
    {
        $validatedData = $this->validate();

        $validatedData['user_id'] = $this->userId;
        $validatedData['dispatcher_id'] = $this->dispatcher_id; // Assign selected dispatcher_id
        $validatedData['created_by_id'] = Auth::id(); // Assign selected dispatcher_id

        if ($this->attachment) {
            // Debugging
            //dd($this->attachment); // Check if attachment object is received
        
            $validatedData['attachment'] = $this->attachment->store('attachments', 'public'); // Store attachment in public disk under the 'attachments' directory
        }
        
        $document = Document::create($validatedData);
        $approvalRequestData = [
            'document_id' => $document->id,
            'assigned_by_id' => Auth::id(),
            'created_by_id' => Auth::id(),
            'assigned_id' =>$document->user_id,
            // Add other fields as needed
        ];
    
        ApprovalRequest::create($approvalRequestData);

        $this->reset();
        session()->flash('message', 'Request saved successfully.');
        $this->mount();
    }

    public function render()
    {
        return view('livewire.request.my-request');
    }
}
