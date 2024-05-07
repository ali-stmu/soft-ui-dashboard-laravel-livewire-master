<?php

namespace App\Http\Livewire\Request;

use App\Models\ApprovalRequest;
use App\Models\Document;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;
use Illuminate\Support\Facades\Log;
use App\Models\User; // Import User model
use App\Models\Department; // Import Department model
use App\Models\Role; // Import Role model

class ForwardWithSignature extends Component
{
    public $requestId;
    public $departments;
    public $roles;    
    public $departmentId;
    public $roleId;
    public $users = [];
    public $userId;
    public $forwardwithsignremarks;
    public $forwardwithsignreturnForwardDate;
    public $request;
    public function mount($requestId)
    {
        $this->request = ApprovalRequest::findOrFail($this->requestId);
        $this->requestId = $requestId;
        $this->departments = Department::all();
        $this->roles = Role::whereIn('name', ['Employee', 'PS/Coordinator'])->get();
        // Fetch users based on the initial role (if available)
        if ($this->roleId) {
            $this->fetchUsers();
        }
    }

    public function render()
    {
        return view('livewire.request.forward-with-signature');
    }
    public function rules()
{
    return [
        'forwardwithsignremarks' => 'required|string|min:3',
        'forwardwithsignreturnForwardDate' => 'required|date',
        'departmentId' => 'required|exists:departments,id',
        'roleId' => 'required|exists:roles,id',
        'userId' => 'required|exists:users,id',
    ];
}

    public function updatedRoleId($value)
    {
        // Update users when role is changed
        $this->roleId = $value;
        $this->fetchUsers();
    }

    public function updatedDepartmentId($value)
    {
        // Update users when department is changed
        $this->departmentId = $value;
        $this->fetchUsers();
    }

    public function forwardwithsignRequest()
    {
        $this->validate(); // Trigger validation
        // Create a new approval request record
        $approvalRequest = ApprovalRequest::create([
            'document_id' => $this->request->document_id,
            'assigned_id' => $this->userId,
            'remarks' => $this->forwardwithsignremarks,
            'signed_date' => $this->forwardwithsignreturnForwardDate,
            'status' => 'finalapproved',
            'assigned_by_id' => Auth::id(),
            'created_by_id' => $this->request->createdBy->id, // Assuming this is the previous request ID
        ]);
        Log::info('Approval Request created', ['request_id' => $approvalRequest->id]);

    
        // Redirect to pending request page after saving
        return redirect()->route('pending-request');
    }
    

    private function fetchUsers()
    {
        // Fetch users based on role, department, and active status
        $this->users = User::where('role_id', $this->roleId)
                           ->when($this->departmentId, function ($query, $departmentId) {
                               return $query->where('department_id', $departmentId);
                           })
                           ->where('status', 'active')
                           ->get();
    }
}