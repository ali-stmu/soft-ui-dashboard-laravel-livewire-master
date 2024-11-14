<?php

namespace App\Http\Livewire\Oric;

use App\Models\Reviewer;
use Livewire\Component;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rule;
use App\Mail\ReviewerCreated;
use Illuminate\Support\Facades\Mail;


class AddReviewer extends Component
{
    public $name, $email, $designation, $institute_name, $country, $password, $reviewer_id;
    public $updateMode = false;
    public $search = ''; // Add a property for the search query


    public function resetInputFields()
    {
        $this->name = '';
        $this->email = '';
        $this->designation = '';
        $this->institute_name = '';
        $this->country = '';
        $this->password = '';
    }

    public function store()
    {
        $validatedData = $this->validate([
            'name' => 'required',
            'email' => 'required|email|unique:reviewers,email',
            'designation' => 'required',
            'institute_name' => 'required',
            'country' => 'required',
            'password' => 'required|min:6',
        ]);
    
        $reviewer = Reviewer::create([
            'name' => $this->name,
            'email' => $this->email,
            'designation' => $this->designation,
            'institute_name' => $this->institute_name,
            'country' => $this->country,
            'password' => Hash::make($this->password),
        ]);
    
        // Send the email notification with the password
        Mail::to($this->email)->send(new ReviewerCreated($reviewer, $this->password));
    
        session()->flash('message', 'Reviewer Added Successfully.');
    
        $this->resetInputFields();
    }
    

    public function edit($id)
    {
        $reviewer = Reviewer::findOrFail($id);
        $this->reviewer_id = $id;
        $this->name = $reviewer->name;
        $this->email = $reviewer->email;
        $this->designation = $reviewer->designation;
        $this->institute_name = $reviewer->institute_name;
        $this->country = $reviewer->country;

        $this->updateMode = true;
    }

    public function update()
    {
        // First, get the existing reviewer record
        $reviewer = Reviewer::find($this->reviewer_id);
    
        // Validate all fields except email
        $this->validate([
            'name' => 'required',
            'designation' => 'required',
            'institute_name' => 'required',
            'country' => 'required',
        ]);
    
        // Validate email separately only if it has changed
        $this->validate([
            'email' => [
                'required',
                'email',
                Rule::unique('reviewers', 'email')->ignore($this->reviewer_id), // Ignore the current reviewer's email
            ],
        ]);
    
        // Update the reviewer details
        $reviewer->update([
            'name' => $this->name,
            'email' => $this->email, // This will be updated only if validation passes
            'designation' => $this->designation,
            'institute_name' => $this->institute_name,
            'country' => $this->country,
        ]);
    
        session()->flash('message', 'Reviewer Updated Successfully.');
    
        // Reset fields and exit update mode
        $this->resetInputFields();
        $this->updateMode = false;
    }
    
    
    

    public function delete($id)
    {
        Reviewer::find($id)->delete();
        session()->flash('message', 'Reviewer Deleted Successfully.');
    }

    public function render()
    {
        // Query the reviewers with search functionality across all relevant columns
        $reviewers = Reviewer::where(function($query) {
                $query->where('name', 'like', '%' . $this->search . '%')
                      ->orWhere('email', 'like', '%' . $this->search . '%')
                      ->orWhere('designation', 'like', '%' . $this->search . '%')
                      ->orWhere('institute_name', 'like', '%' . $this->search . '%')
                      ->orWhere('country', 'like', '%' . $this->search . '%');
            })
            ->paginate(10); // Adjust the pagination limit as needed
    
        return view('livewire.oric.add-reviewer', ['reviewers' => $reviewers]);
    }
    
}
