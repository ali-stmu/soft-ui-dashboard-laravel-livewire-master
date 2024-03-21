<?php

namespace App\Http\Livewire\Auth;
use Laravel\Socialite\Facades\Socialite;
use Livewire\Component;
use App\Models\User;

class Login extends Component
{
    public $email = '';
    public $password = '';
    public $remember_me = false;

    protected $rules = [
        'email' => 'required|email:rfc,dns',
        'password' => 'required',
    ];
    public function loginWithGoogle(){
    return redirect()->away(Socialite::driver('google')->redirect()->getTargetUrl());
    }

    public function handleGoogleCallback()
{
    try {
        $user = Socialite::driver('google')->user();
    } catch (\Exception $e) {
        return redirect('/login')->withErrors(['error' => 'Failed to authenticate with Google.']);
    }

    // Check if the user already exists
    $existingUser = User::where('email', $user->email)->first();

    if ($existingUser) {
        auth()->login($existingUser, true); // Login the user
        return redirect('/dashboard');
    } else {
        // User doesn't exist, create a new one
        // $newUser = User::create([
        //     'name' => $user->name,
        //     'email' => $user->email,
        //     'google_id' => $user->getId(),
        //     'email_verified_at' => \Carbon\Carbon::now()->addHours(5),
        //     // You may need additional fields depending on your User model
        // ]);

        // auth()->login($newUser, true); // Login the new user
        // return redirect('/dashboard');
        return redirect('/login')->withErrors(['error' => 'Failed to authenticate with Google.']);
    }
}


    
    public function mount() {
        if(auth()->user()){
            redirect('/dashboard');
        }
        //$this->fill(['email' => 'admin@softui.com', 'password' => 'secret']);
    }

    public function login() {
        $credentials = $this->validate();
        if(auth()->attempt(['email' => $this->email, 'password' => $this->password], $this->remember_me)) {
            $user = User::where(["email" => $this->email])->first();
            auth()->login($user, $this->remember_me);
            return redirect()->intended('/dashboard');        
        }
        else{
            return $this->addError('email', trans('auth.failed')); 
        }
    }

    public function render()
    {
        return view('livewire.auth.login');
    }
}
