<?php

use Illuminate\Support\Facades\Route;

use App\Http\Livewire\Auth\ForgotPassword;
use App\Http\Livewire\Auth\ResetPassword;
use App\Http\Livewire\Auth\SignUp;
use App\Http\Livewire\Auth\Login;
use App\Http\Livewire\Dashboard;
use App\Http\Livewire\Billing;
use App\Http\Livewire\Profile;
use App\Http\Livewire\Tables;
use App\Http\Livewire\AddFaculty;
use App\Http\Livewire\AddDepartment;
use App\Http\Livewire\AddDesignation;
use App\Http\Livewire\AddUser;
use App\Http\Livewire\Request\PendingRequest;
use App\Http\Livewire\Request\MyRequest;
use App\Http\Livewire\Request\CompletedRequest;
use App\Http\Livewire\StaticSignIn;
use App\Http\Livewire\StaticSignUp;
use App\Http\Livewire\Rtl;

use App\Http\Livewire\LaravelExamples\UserProfile;
use App\Http\Livewire\LaravelExamples\UserManagement;
use App\Http\Livewire\Request\ForwardWithSignature;
use App\Http\Livewire\Request\ForwardedRequests;
use App\Http\Livewire\Request\DocumentTimeline;

use App\Http\Livewire\Oric\OricForm;
use App\Http\Livewire\Oric\AddReviewer;
use App\Http\Livewire\Oric\ViewResearchGrants;
use App\Http\Livewire\Oric\ShowResearchGrant;
use App\Http\Livewire\Oric\SubmittedResearchGrants;


use Illuminate\Http\Request;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function() {
    return redirect('/login');
});

Route::get('/sign-up', SignUp::class)->name('sign-up');
Route::get('/login', Login::class)->name('login');
Route::get('login/google/callback', 'App\Http\Livewire\Auth\Login@handleGoogleCallback');

Route::get('/login/forgot-password', ForgotPassword::class)->name('forgot-password');

Route::get('/reset-password/{id}',ResetPassword::class)->name('reset-password')->middleware('signed');

Route::middleware('auth')->group(function () {
    Route::get('/dashboard', Dashboard::class)->name('dashboard');
    Route::get('/billing', Billing::class)->name('billing');
    Route::get('/profile', Profile::class)->name('profile');
    Route::get('/tables', Tables::class)->name('tables');
    Route::get('/pending-request', PendingRequest::class)->name('pending-request');
    Route::get('/forward-with-signature/{requestId}', ForwardWithSignature::class)->name('forward-with-signature');

    Route::get('/my-request', MyRequest::class)->name('my-request');
    Route::get('/completed-request', CompletedRequest::class)->name('completed-request');
    Route::get('/forwarded-request', ForwardedRequests::class)->name('forwarded-request');
    Route::get('/static-sign-in', StaticSignIn::class)->name('sign-in');
    Route::get('/static-sign-up', StaticSignUp::class)->name('static-sign-up');
    Route::get('/rtl', Rtl::class)->name('rtl');
    Route::get('/laravel-user-profile', UserProfile::class)->name('user-profile');
    Route::get('/laravel-user-management', UserManagement::class)->name('user-management');

    //ORIC Routes
    Route::get('/oric-form/{formId?}', OricForm::class)->name('oric-form');
    Route::get('/submitted-research-grant', SubmittedResearchGrants::class)->name('submitted-research-grant');
    Route::get('/research-grants/{id}', ShowResearchGrant::class)->name('research-grants.show');
    Route::get('/research-grants', ViewResearchGrants::class)->name('research-grants.index');

    Route::group(['middleware' => ['auth', 'director_oric']], function () {
        
        Route::get('/add-reviewer', AddReviewer::class)->name('add-reviewer');
        //Route::get('/view-research-grants', ViewResearchGrants::class)->name('view-research-grants');
    });



     // Routes accessible only to VC
    Route::group(['middleware' => ['role:VC']], function () {
        Route::get('/add-faculty', AddFaculty::class)->name('add-faculty');
        Route::get('/add-department', AddDepartment::class)->name('add-department');
        Route::get('/add-designation', AddDesignation::class)->name('add-designation');
        Route::get('/add-user', AddUser::class)->name('add-user');
        Route::get('/document-timeline', DocumentTimeline::class)->name('document-timeline');


        // ... other VC specific routes
    });
    
});