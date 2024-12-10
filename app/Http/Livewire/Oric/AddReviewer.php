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
    public $name, $email, $designation_name, $institute_name, $country, $password, $reviewer_id;
    public $updateMode = false;
    public $search = ''; // Add a property for the search query

    public function resetInputFields()
    {
        $this->name = '';
        $this->email = '';
        $this->designation_name = '';
        $this->institute_name = '';
        $this->country = '';
        $this->password = '';
    }

    public function store()
    {
        $validatedData = $this->validate([
            'name' => 'required',
            'email' => 'required|email|unique:users,email',
            'designation_name' => 'required',
            'institute_name' => 'required',
            'country' => 'required',
            'password' => 'required|min:6',
        ]);

        // Add the reviewer as a user to the users table with role_id = 11
        $user = \App\Models\User::create([
            'name' => $this->name,
            'email' => $this->email,
            'password' => Hash::make($this->password),
            'country' => $this->country,  // Adding country
            'institute' => $this->institute_name,
            'designation_name' => $this->designation_name,
            'role_id' => 11, // Assigning role_id = 11
        ]);

        // Send the email notification with the password
        Mail::to($this->email)->send(new ReviewerCreated($user, $this->password));

        session()->flash('message', 'Reviewer Added Successfully.');

        $this->resetInputFields();
    }

    public function edit($id)
    {
        // Fetch user with role_id = 11
        $user = \App\Models\User::where('id', $id)->where('role_id', 11)->firstOrFail();

        $this->reviewer_id = $id;
        $this->name = $user->name;
        $this->email = $user->email;
        $this->designation_name = $user->designation_name;
        $this->institute_name = $user->institute;
        $this->country = $user->country;

        $this->updateMode = true;
    }

    public function update()
    {
        $user = \App\Models\User::findOrFail($this->reviewer_id);

        // Validate fields
        $this->validate([
            'name' => 'required',
            'email' => [
                'required',
                'email',
                Rule::unique('users', 'email')->ignore($user->id), // Ignore current user's email
            ],
            'designation_name' => 'required',
            'institute_name' => 'required',
            'country' => 'required',
        ]);

        // Update the user record
        $user->update([
            'name' => $this->name,
            'email' => $this->email,
            'designation_name' => $this->designation_name,
            'institute' => $this->institute_name,
            'country' => $this->country,
        ]);

        session()->flash('message', 'Reviewer Updated Successfully.');

        $this->resetInputFields();
        $this->updateMode = false;
    }

    public function delete($id)
    {
        // Delete user with role_id = 11
        $user = \App\Models\User::where('id', $id)->where('role_id', 11)->firstOrFail();
        $user->delete();

        session()->flash('message', 'Reviewer Deleted Successfully.');
    }

    public function render()
    {
        // Query the reviewers with search functionality across all relevant columns
        $reviewers = \App\Models\User::where('role_id', 11) // Add the role_id condition
            ->where(function ($query) {
                $query->where('name', 'like', '%' . $this->search . '%')
                      ->orWhere('email', 'like', '%' . $this->search . '%')
                      ->orWhere('designation_name', 'like', '%' . $this->search . '%')
                      ->orWhere('institute', 'like', '%' . $this->search . '%')
                      ->orWhere('country', 'like', '%' . $this->search . '%');
            })
            ->paginate(10); // Adjust the pagination limit as needed

        return view('livewire.oric.add-reviewer', ['reviewers' => $reviewers]);
    }
}
