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
        // Validate the input
        $this->validate([
            'selectedFormId' => 'required',
            'selectedReviewers' => 'required|array|min:1', // Ensure at least one reviewer is selected
        ]);
    
        try {
            // Get the selected form title
            $form = OricFormModal::find($this->selectedFormId);
            $formTitle = $form->project_title;
    
            // Loop through the selected reviewers and save them in the 'forwards' table
            foreach ($this->selectedReviewers as $reviewerId) {
                // Save the forward record
                Forward::create([
                    'form_id' => $this->selectedFormId,
                    'director_id' => Auth::id(), // Logged-in user as the director
                    'reviewer_id' => $reviewerId,
                    'status' => 1,
                ]);
    
                // Get reviewer details
                $reviewer = Reviewer::find($reviewerId);
                $reviewerName = $reviewer->name;
    
                // Send email to the reviewer
                Mail::to($reviewer->email)->send(new OricFormForwarded($formTitle, $reviewerName, $this->selectedFormId));
            }
    
            session()->flash('message', 'Form forwarded successfully!');
    
            // Reset selected reviewers and close modal
            $this->reset('selectedFormId', 'selectedReviewers');
        } catch (\Exception $e) {
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
            // Get the reviewer IDs already forwarded for the selected form
            $forwardedReviewerIds = Forward::where('form_id', $this->selectedFormId)
                ->pluck('reviewer_id')
                ->toArray();
    
            // Fetch reviewers excluding the forwarded ones
            $this->reviewers = Reviewer::whereNotIn('id', $forwardedReviewerIds)->get();
        } else {
            // Fetch all reviewers if no form is selected
            $this->reviewers = Reviewer::all();
        }
    }
    public function updatedSelectedFormId($formId)
    {
        if ($formId) {
            $forwardedReviewerIds = Forward::where('form_id', $formId)
                ->pluck('reviewer_id')
                ->toArray();

            $this->reviewers = Reviewer::whereNotIn('id', $forwardedReviewerIds)->get();
        } else {
            $this->reviewers = Reviewer::all();
        }
    }

    
    public function render()
    {
        // Fetch paginated results based on the search query
        $oricForms = OricFormModal::where('project_title', 'like', '%' . $this->search . '%')
            ->orWhere('pi_name', 'like', '%' . $this->search . '%')
            ->paginate(10);

        return view('livewire.oric.view-research-grants', [
            'oricForms' => $oricForms,
            'reviewers' => $this->reviewers, // Pass reviewers to the view

        ]);
    }
}
