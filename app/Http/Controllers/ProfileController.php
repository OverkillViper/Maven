<?php

namespace App\Http\Controllers;

use App\Http\Requests\ProfileUpdateRequest;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redirect;
use Inertia\Inertia;
use Inertia\Response;
use Illuminate\Support\Facades\Storage;
use Carbon\Carbon;

class ProfileController extends Controller
{
    /**
     * Display the user's profile form.
     */
    public function edit(Request $request): Response
    {
        return Inertia::render('Profile/Edit', [
            'mustVerifyEmail' => $request->user() instanceof MustVerifyEmail,
            'status' => session('status'),
        ]);
    }

    /**
     * Update the user's profile information.
     */
    public function update(ProfileUpdateRequest $request): RedirectResponse
    {
        $request->user()->fill($request->validated());

        if ($request->user()->isDirty('email')) {
            $request->user()->email_verified_at = null;
        }

        $request->user()->save();

        return Redirect::route('profile.edit');
    }

    /**
     * Delete the user's account.
     */
    public function destroy(Request $request): RedirectResponse
    {
        $request->validate([
            'password' => ['required', 'current_password'],
        ]);

        $user = $request->user();

        Auth::logout();

        $user->delete();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return Redirect::to('/');
    }

    private function redirectToProfile(string $status, string $topic) {
        $successContext = [
            'status'  => $status,
            'message' => "Successfully updated " . $topic,
        ];

        $errorContext = [
            'status'  => $status,
            'message' => "Error updating " . $topic,
        ];
        
        if(Auth::user()->isAdmin) {
            return redirect()->route('admin.profile')->with($status == 'success' ? $successContext : $errorContext);
        } else {
            return redirect()->route('employee.profile')->with($status == 'success' ? $successContext : $errorContext);
        }
    }

    public function updateGeneralInformation(Request $request) {
        $data = $request->validate([
            'first_name' => 'required|string|max:255',
            'last_name'  => 'required|string|max:2551',
            'email'      => 'required|email',
        ]);

        $updatedUser = Auth::user()->update($data);

        if($updatedUser) {
            $this->redirectToProfile('success', "general information");
        } else {
            $this->redirectToProfile('error', "general information");
        }
    }

    public function changeProfilePicture(Request $request) {

        $data = $request->validate([
            'avatar' => 'required'
        ]);

        if ($request->hasFile('avatar')) {
            if (isset(Auth::user()->employee->avatar)) {
                Storage::disk('public')->delete(Auth::user()->employee->avatar);
            }
            $avatarPath = $request->file('avatar')->store('images/avatars', 'public');

            $data['avatar'] = $avatarPath;

            $updatedUser = Auth::user()->employee->update($data);

            if($updatedUser) {
                $this->redirectToProfile('success', "avatar");
            } else {
                $this->redirectToProfile('error', "avatar");
            }
        }
    }

    public function updateJobDetails(Request $request) {

        $joined_at    = $request->joined_at ? Carbon::parse($request->joined_at)->format('Y-m-d') : $request->joined_at;
        $permanent_at = $request->servicetype == 'Permanent' && Auth::user()->employee->servicetype == 'Probation' ? Carbon::parse(Carbon::now())->format('Y-m-d') : ($request->permanent_at ? Carbon::parse($request->permanent_at)->format('Y-m-d') : $request->permanent_at);

        Auth::user()->employee->employee_id    = $request->employee_id;
        Auth::user()->employee->department_id  = $request->input('department.id');
        Auth::user()->employee->designation_id = $request->input('designation.id');
        Auth::user()->employee->servicetype    = $request->servicetype;
        Auth::user()->employee->job_location   = $request->job_location;
        Auth::user()->employee->salary         = $request->salary;
        Auth::user()->employee->joined_at      = $joined_at;
        Auth::user()->employee->permanent_at   = $permanent_at;
        $updatedUser = Auth::user()->employee->save();

        if($updatedUser) {
            $this->redirectToProfile('success', "job details");
        } else {
            $this->redirectToProfile('error', "job details");
        }
    }

    public function updatePersonalInformation(Request $request) {
        $date_of_birth = $request->date_of_birth ? Carbon::parse($request->date_of_birth)->format('Y-m-d') : $request->date_of_birth;

        Auth::user()->employee->date_of_birth    = $date_of_birth;
        Auth::user()->employee->marital_status   = $request->marital_status;
        Auth::user()->employee->gender           = $request->gender;
        Auth::user()->employee->title            = $request->title;
        Auth::user()->employee->blood_group      = $request->blood_group;
        Auth::user()->employee->contact          = $request->contact;
        Auth::user()->employee->nid              = $request->nid;
        Auth::user()->employee->passport         = $request->passport;
        Auth::user()->employee->driving_license  = $request->driving_license;
        Auth::user()->employee->religion         = $request->religion;
        Auth::user()->employee->nationality      = $request->nationality;
        Auth::user()->employee->father_name      = $request->father_name;
        Auth::user()->employee->mother_name      = $request->mother_name;
        Auth::user()->employee->spouse_name      = $request->spouse_name;

        $updatedUser = Auth::user()->employee->save();

        if($updatedUser) {
            $this->redirectToProfile('success', "personal information");
        } else {
            $this->redirectToProfile('error', "personal information");
        }
    }

}
