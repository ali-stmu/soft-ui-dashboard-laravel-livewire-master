<?php

namespace App\Http\Livewire\Oric;

use Livewire\Component;
use Livewire\WithFileUploads;
use App\Models\OricFormModal; // Make sure to import your model
use Illuminate\Support\Facades\Auth;

class OricForm extends Component
{
    use WithFileUploads; // Include this trait for file uploads

    public $project_title, $expected_start_date, $duration_of_project, $total_fund_requested;
    public $pi_name, $pi_designation, $pi_email, $pi_mobile, $pi_landline, $pi_department, $pi_institution;
    public $co_pi_name, $co_pi_designation, $co_pi_department, $co_pi_institution;
    public $irb_approval_number, $attachment_irb_and_ec, $irb_ec_approval_letter_certificate;
    public $significance_answer, $distinct_value_answer, $research_plan_answer, $aims_and_objectives;
    public $milestones_and_deliverables, $work_plan_attachment, $economic_significance, $financial_request;

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
        $validatedData['user_id'] = Auth::id(); // Get the authenticated user ID

        // Handle file uploads
        if ($this->attachment_irb_and_ec) {
            $validatedData['attachment_irb_and_ec'] = $this->attachment_irb_and_ec->store('uploads/irb', 'public');
            \Log::info('IRB Attachment Path: ' . $validatedData['attachment_irb_and_ec']);
        }
        
        // Repeat for other attachments...
        
        
        if ($this->irb_ec_approval_letter_certificate) {
            $validatedData['irb_ec_approval_letter_certificate'] = $this->irb_ec_approval_letter_certificate->store('uploads/irb', 'public'); // Customize the path as needed
        }
        
        if ($this->work_plan_attachment) {
            $validatedData['work_plan_attachment'] = $this->work_plan_attachment->store('uploads/work_plans', 'public'); // Customize the path as needed
        }
        
        // Create a new record in the OricForm table
        OricFormModal::create($validatedData);

        session()->flash('message', 'Form submitted successfully.');
         // Reset form fields
        $this->reset([
        'project_title', 'expected_start_date', 'duration_of_project', 'total_fund_requested',
        'pi_name', 'pi_designation', 'pi_email', 'pi_mobile', 'pi_landline', 'pi_department', 'pi_institution',
        'co_pi_name', 'co_pi_designation', 'co_pi_department', 'co_pi_institution',
        'irb_approval_number', 'attachment_irb_and_ec', 'irb_ec_approval_letter_certificate',
        'significance_answer', 'distinct_value_answer', 'research_plan_answer', 'aims_and_objectives',
        'milestones_and_deliverables', 'work_plan_attachment', 'economic_significance', 'financial_request'
    ]);

        return ;
        
    }

    public function render()
    {
        return view('livewire.oric.oric-form');
    }
}
