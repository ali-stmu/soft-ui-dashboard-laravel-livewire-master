<?php

namespace App\Http\Livewire\Oric;

use Livewire\Component;
use App\Models\OricFormModal;
use App\Models\Remark;
use App\Models\Reviewer;
use App\Models\Forward;  // Import the Forward model
use App\Mail\OricFormForwarded; // Import the mailable class
use Illuminate\Support\Facades\Auth;
use Livewire\WithPagination;
use App\Mail\OricSubmissionReturned;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Log;

class ViewResearchGrants extends Component
{
    use WithPagination;

    public $search = ''; // To store the search query
    public $remarksTitle; // For the remarks input
    public $selectedFormId; // To store the selected ORIC form ID
    public $selectedUserId; // To store the selected user ID
    public $reviewers = []; // List of all reviewers
    public $selectedReviewers = []; // Multi-select list of selected reviewers
    protected $paginationTheme = 'bootstrap'; // Optional: Use Bootstrap pagination theme

    public function updatingSearch()
    {
        // Reset the page number if the search query is updated
        $this->resetPage();
    }
    public function forwardForm()
    {
        $this->validate([
            'selectedFormId' => 'required',
            'selectedReviewers' => 'required|array|min:1', // Ensure at least one reviewer is selected
        ]);
    
        try {
            Log::debug("inside try");
    
            // Get the selected form
            $form = OricFormModal::findOrFail($this->selectedFormId);
            $formTitle = $form->project_title;
            Log::debug($formTitle);
    
            // Update the form status
            $form->update(['status_id' => 1]); // Assuming 1 represents 'Forwarded'
    
            // Filter valid reviewers
            $validReviewers = \App\Models\User::where('role_id', 11)
                ->whereIn('id', $this->selectedReviewers)
                ->pluck('id')
                ->toArray();
    
            if (count($validReviewers) !== count($this->selectedReviewers)) {
                throw new \Exception("One or more selected reviewers are invalid.");
            }
    
            // Insert into the forwards table
            foreach ($validReviewers as $reviewerId) {
                Forward::create([
                    'form_id' => $this->selectedFormId,
                    'director_id' => Auth::id(), // Logged-in user as the director
                    'reviewer_id' => $reviewerId,
                    'status' => 1, // Assuming 1 means forwarded
                ]);
    
                // Notify the reviewer
                $reviewer = \App\Models\User::find($reviewerId);
                Mail::to($reviewer->email)->send(new OricFormForwarded($formTitle, $reviewer->name, $this->selectedFormId));
            }
    
            session()->flash('message', 'Form forwarded successfully!');
            $this->reset('selectedFormId', 'selectedReviewers');
        } catch (\Exception $e) {
            Log::error($e->getMessage());
            session()->flash('error', 'Failed to forward form: ' . $e->getMessage());
        }
    }
    
    
    
    public function submitRemark()
    {
        \Log::info('Submit Remark called', [
            'remarksTitle' => $this->remarksTitle,
            'selectedUserId' => $this->selectedUserId,
            'selectedFormId' => $this->selectedFormId,
        ]);
    
        // Validate the input
        $this->validate([
            'remarksTitle' => 'required|string',
            'selectedUserId' => 'required',
            'selectedFormId' => 'required',
        ]);
    
        try {
            // Check if a remark already exists for the selected form
            $remark = Remark::where('form_id', $this->selectedFormId)->first();
    
            if ($remark) {
                // Update the existing remark
                $remark->update([
                    'title' => $this->remarksTitle,
                    'director_id' => Auth::id(), // Optional: Only if the director changes
                ]);
            } else {
                // Create a new remark
                Remark::create([
                    'title' => $this->remarksTitle,
                    'director_id' => Auth::id(),
                    'initiator_id' => $this->selectedUserId,
                    'form_id' => $this->selectedFormId,
                ]);
            }
            // Update the ORIC form status
            $oricForm = OricFormModal::find($this->selectedFormId);
            if ($oricForm) {
                $oricForm->status_id = 5; // Set the status_id to 5
                $oricForm->save();
            }

    
            // Fetch the initiator's email
            $initiatorEmail = OricFormModal::find($this->selectedFormId)->user->email;
            $initiatorName = OricFormModal::find($this->selectedFormId)->user->name;
    
            // Send the email notification
            Mail::to($initiatorEmail)->send(new OricSubmissionReturned($this->remarksTitle, $initiatorName, $this->selectedFormId));
    
            // Reset fields
            $this->reset('remarksTitle', 'selectedUserId', 'selectedFormId');
    
            // Show a success message
            session()->flash('message', 'Remark saved successfully!');
    
            // Trigger a page refresh using Livewire's JavaScript
            $this->dispatchBrowserEvent('refresh-page');
        } catch (\Exception $e) {
            session()->flash('error', 'Failed to save remark: ' . $e->getMessage());
        }
    }
    public function mount()
    {
        if ($this->selectedFormId) {
            // Get the user IDs (reviewers) already forwarded for the selected form
            $forwardedReviewerIds = Forward::where('form_id', $this->selectedFormId)
                ->pluck('user_id') // Changed from `reviewer_id` to `user_id`
                ->toArray();
    
            // Fetch users with role_id = 11 (reviewers), excluding the forwarded ones
            $this->reviewers = \App\Models\User::where('role_id', 11)
                ->whereNotIn('id', $forwardedReviewerIds)
                ->get();
        } else {
            // Fetch all users with role_id = 11 if no form is selected
            $this->reviewers = \App\Models\User::where('role_id', 11)->get();
        }
    }
    
    public function updatedSelectedFormId($formId)
    {
        if ($formId) {
            // Get the user IDs (reviewers) already forwarded for the selected form
            $forwardedReviewerIds = Forward::where('form_id', $formId)
                ->pluck('reviewer_id') // Changed from `reviewer_id` to `user_id`
                ->toArray();
    
            // Fetch users with role_id = 11 (reviewers), excluding the forwarded ones
            $this->reviewers = \App\Models\User::where('role_id', 11)
                ->whereNotIn('id', $forwardedReviewerIds)
                ->get();
        } else {
            // Fetch all users with role_id = 11 if no form is selected
            $this->reviewers = \App\Models\User::where('role_id', 11)->get();
        }
    }
    
    
    public function render()
    {
        // Fetch paginated results based on the search query
        $oricForms = OricFormModal::where('project_title', 'like', '%' . $this->search . '%')
            ->orWhere('pi_name', 'like', '%' . $this->search . '%')
            ->paginate(10);
    
        // Determine if the form is forwarded or not
        foreach ($oricForms as $form) {
            $form->is_forwarded = Forward::where('form_id', $form->id)->exists();
        }
    
        return view('livewire.oric.view-research-grants', [
            'oricForms' => $oricForms,
            'reviewers' => $this->reviewers, // Pass reviewers to the view
        ]);
    }
    
}
