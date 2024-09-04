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
use Livewire\WithPagination;


class MyRequest extends Component
{
    use WithFileUploads, WithPagination;
    protected $paginationTheme = 'bootstrap'; // Optional, if you want Bootstrap-styled pagination

    public $title, $description, $attachment, $dispatch_date, $approved_date, $dispatcher_id;
    public $dispatchers, $departments, $roles;
    public $departmentId, $roleId, $users = [], $userId, $search = '';

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
        $this->dispatchers = User::pluck('name', 'id');
        $this->departments = Department::all();
        $this->roles = Role::whereIn('name', ['Employee', 'PS/Coordinator'])->get();
    }

    public function save()
    {
        $validatedData = $this->validate();
    
        $validatedData['user_id'] = $this->userId;
        $validatedData['dispatcher_id'] = $this->dispatcher_id;
        $validatedData['created_by_id'] = Auth::id();
        $validatedData['department_id'] = Auth::user()->department_id;
    
        if ($this->attachment) {
            $validatedData['attachment'] = $this->attachment->store('attachments', 'public');
        }
    
        $document = Document::create($validatedData);
        $documentUser = User::find($document->user_id);
        $approvalRequestData = [
            'document_id' => $document->id,
            'assigned_by_id' => Auth::id(),
            'created_by_id' => Auth::id(),
            'assigned_id' => $document->user_id,
            'department_id' => $documentUser->department_id,
        ];
    
        ApprovalRequest::create($approvalRequestData);
    
        // Fetch users for notification
        $assignedUser = User::find($document->user_id);
        $dispatcher = User::find($document->dispatcher_id);
        $creator = Auth::user();
    
        // Send email notifications
        \Mail::to($assignedUser->email)->cc([$dispatcher->email, $creator->email])->send(new \App\Mail\DocumentAssignedNotification($document, $assignedUser, $creator));
        \Mail::to($creator->email)->send(new \App\Mail\DocumentCreatedNotification($document, $creator));
        \Mail::to($dispatcher->email)->send(new \App\Mail\DispatcherNotification($document, $dispatcher, $creator));
    
        $this->reset();
        session()->flash('message', 'Request saved successfully.');
        $this->mount();
    }
    


    public function render()
    {
        $query = Document::query();

        if ($this->search) {
            $query->where(function($subQuery) {
                $subQuery->where('title', 'like', '%' . $this->search . '%')
                         ->orWhere('description', 'like', '%' . $this->search . '%')
                         ->orWhere('id', 'like', '%' . $this->search . '%'); // Include ID in the search
            });
        }
    
        $documents = $query->paginate(5);

        return view('livewire.request.my-request', [
            'documents' => $documents
        ]);
    }
}
