<?php

namespace App\Http\Livewire\Oric;

use Livewire\Component;
use Livewire\WithFileUploads;
use App\Models\OricFormModal; // Make sure to import your model
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use App\Mail\OricFormCreated;
use App\Models\User;
use Illuminate\Support\Facades\Mail;


class OricForm extends Component
{
    use WithFileUploads; // Include this trait for file uploads
    protected $listeners = ['loadFormData'];

    public $formId; // ID of the form to edit
    public $project_title, $expected_start_date, $duration_of_project, $total_fund_requested;
    public $pi_name, $pi_designation, $pi_email, $pi_mobile, $pi_landline, $pi_department, $pi_institution;
    public $co_pi_name, $co_pi_designation, $co_pi_department, $co_pi_institution;
    public $irb_approval_number, $attachment_irb_and_ec, $irb_ec_approval_letter_certificate;
    public $significance_answer, $distinct_value_answer, $research_plan_answer, $aims_and_objectives;
    public $milestones_and_deliverables, $work_plan_attachment, $economic_significance, $financial_request;
    public $existing_irb_attachment; // For displaying existing attachment
    public $existing_work_plan_attachment; // For displaying existing work plan
    public $existing_irb_ec_approval_letter_certificate; // For displaying existing work plan

    

    protected $rules = [
        'project_title' => 'required|string|max:255',
        'expected_start_date' => 'required|date',
        'duration_of_project' => 'required|integer|min:1',
        'total_fund_requested' => 'required|numeric|min:0',
        'pi_name' => 'required|string|max:255',
        'pi_designation' => 'required|string|max:255',
        'pi_email' => 'required|email|max:255',
        'pi_mobile' => 'required|string|max:20',
        'pi_landline' => 'nullable|string|max:20',
        'pi_department' => 'required|string|max:255',
        'pi_institution' => 'required|string|max:255',
        'co_pi_name' => 'nullable|string|max:255',
        'co_pi_designation' => 'nullable|string|max:255',
        'co_pi_department' => 'nullable|string|max:255',
        'co_pi_institution' => 'nullable|string|max:255',
        'irb_approval_number' => 'nullable|string|max:255',
        'attachment_irb_and_ec' => 'nullable|file|mimes:pdf|max:2048', // Specify file type
        'irb_ec_approval_letter_certificate' => 'nullable|file|mimes:pdf|max:2048', // Specify file type
        'significance_answer' => 'nullable|string',
        'distinct_value_answer' => 'nullable|string',
        'research_plan_answer' => 'nullable|string',
        'aims_and_objectives' => 'nullable|string',
        'milestones_and_deliverables' => 'nullable|string',
        'work_plan_attachment' => 'nullable|file|mimes:pdf|max:2048', // Specify file type
        'economic_significance' => 'nullable|string',
        'financial_request' => 'nullable|string',
    ];

    public function submit()
    {
        $validatedData = $this->validate();

        // Handle file uploads
        if ($this->attachment_irb_and_ec) {
            $validatedData['attachment_irb_and_ec'] = $this->attachment_irb_and_ec->store('uploads/irb', 'public');
        } elseif (isset($this->existing_irb_attachment)) {
            $validatedData['attachment_irb_and_ec'] = $this->existing_irb_attachment; // Keep existing
        }
        if ($this->irb_ec_approval_letter_certificate) {
            $validatedData['irb_ec_approval_letter_certificate'] = $this->irb_ec_approval_letter_certificate->store('uploads/irb', 'public');
        } elseif (isset($this->existing_irb_ec_approval_letter_certificate)) {
            $validatedData['irb_ec_approval_letter_certificate'] = $this->existing_irb_ec_approval_letter_certificate; // Keep existing
        }

        if ($this->work_plan_attachment) {
            $validatedData['work_plan_attachment'] = $this->work_plan_attachment->store('uploads/work_plans', 'public');
        } elseif (isset($this->existing_work_plan_attachment)) {
            $validatedData['work_plan_attachment'] = $this->existing_work_plan_attachment; // Keep existing
        }
        

        $validatedData['status_id'] = 4;

        if ($this->formId) {
            $form = OricFormModal::find($this->formId);
            $form->update($validatedData);
        } else {
            $validatedData['user_id'] = Auth::id();
            OricFormModal::create($validatedData);
        }
        $directorsOric = User::whereHas('role', function ($query) {
            $query->where('name', 'Director ORIC');
        })->get();
    
        foreach ($directorsOric as $director) {
            Mail::to($director->email)->send(new OricFormCreated($validatedData));
        }

        session()->flash('message', 'Form submitted successfully.');
        return redirect()->route('submitted-research-grant');
    }
    
public function mount($formId = null)
    {
        // If a formId is passed, load the existing form data
        if ($formId) {
            $form = OricFormModal::find($formId);

            if ($form) {
                $this->formId = $form->id;
                $this->project_title = $form->project_title;
                $this->expected_start_date = $form->expected_start_date;
                $this->duration_of_project = $form->duration_of_project;
                $this->total_fund_requested = $form->total_fund_requested;
                $this->pi_name = $form->pi_name;
                $this->pi_designation = $form->pi_designation;
                $this->pi_email = $form->pi_email;
                $this->pi_mobile = $form->pi_mobile;
                $this->pi_landline = $form->pi_landline;
                $this->pi_department = $form->pi_department;
                $this->pi_institution = $form->pi_institution;
                $this->co_pi_name = $form->co_pi_name;
                $this->co_pi_designation = $form->co_pi_designation;
                $this->co_pi_department = $form->co_pi_department;
                $this->co_pi_institution = $form->co_pi_institution;
                $this->irb_approval_number = $form->irb_approval_number;
                $this->significance_answer = $form->significance_answer;
                $this->distinct_value_answer = $form->distinct_value_answer;
                $this->research_plan_answer = $form->research_plan_answer;
                $this->aims_and_objectives = $form->aims_and_objectives;
                $this->milestones_and_deliverables = $form->milestones_and_deliverables;
                $this->economic_significance = $form->economic_significance;
                $this->financial_request = $form->financial_request;
                $this->existing_irb_attachment = $form->attachment_irb_and_ec; // For existing file
                $this->existing_work_plan_attachment = $form->work_plan_attachment; // For existing work plan
                $this->existing_irb_ec_approval_letter_certificate = $form->irb_ec_approval_letter_certificate; // For existing work plan
            
            }
        }
    }
    public function loadFormData($formId)
{
    $oricForm = OricFormModal::findOrFail($formId); // Fetch the form by ID
    
    // Populate the form fields
    $this->project_title = $oricForm->project_title;
    $this->expected_start_date = $oricForm->expected_start_date;
    $this->duration_of_project = $oricForm->duration_of_project;
    $this->total_fund_requested = $oricForm->total_fund_requested;
    $this->pi_name = $oricForm->pi_name;
    $this->pi_designation = $oricForm->pi_designation;
    $this->pi_email = $oricForm->pi_email;
    $this->pi_mobile = $oricForm->pi_mobile;
    $this->pi_landline = $oricForm->pi_landline;
    $this->pi_department = $oricForm->pi_department;
    $this->pi_institution = $oricForm->pi_institution;
    $this->co_pi_name = $oricForm->co_pi_name;
    $this->co_pi_designation = $oricForm->co_pi_designation;
    $this->co_pi_department = $oricForm->co_pi_department;
    $this->co_pi_institution = $oricForm->co_pi_institution;
    $this->irb_approval_number = $oricForm->irb_approval_number;
    $this->significance_answer = $oricForm->significance_answer;
    $this->distinct_value_answer = $oricForm->distinct_value_answer;
    $this->research_plan_answer = $oricForm->research_plan_answer;
    $this->aims_and_objectives = $oricForm->aims_and_objectives;
    $this->milestones_and_deliverables = $oricForm->milestones_and_deliverables;
    $this->economic_significance = $oricForm->economic_significance;
    $this->financial_request = $oricForm->financial_request;

    // Handle file fields if necessary (optional)
     $this->attachment_irb_and_ec = $oricForm->attachment_irb_and_ec;
     $this->irb_ec_approval_letter_certificate = $oricForm->irb_ec_approval_letter_certificate;
     $this->work_plan_attachment = $oricForm->work_plan_attachment;
}

public function render()
    {
        return view('livewire.oric.oric-form', [
            'selectedFormId' => $this->formId,
            'existing_irb_attachment' => $this->existing_irb_attachment,
            'existing_work_plan_attachment' => $this->existing_work_plan_attachment,
            'existing_irb_ec_approval_letter_certificate' => $this->existing_irb_ec_approval_letter_certificate
        ]);
    }

}
