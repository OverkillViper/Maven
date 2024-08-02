<?php

namespace App\Http\Controllers;

use App\Models\Department;
use App\Models\Designation;
use Illuminate\Http\Request;
use App\Models\Breadcrumb;
use Inertia\Inertia;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Auth;

class AdminController extends Controller
{
    public function dashboard(Request $request) {

        $context = [
            'breadcrumb' => $request->breadcrumb,
        ];

        return Inertia::render('Admin/Dashboard', $context);
    }

    public function departments(Request $request) {
        $departments = Department::with('children')->whereNull('parent_id')->get();

        $context = [
            'departments' => $departments,
            'breadcrumb' => $request->breadcrumb,
        ];

        return Inertia::render('Admin/Departments', $context);
    }

    public function createDepartment(Request $request) {
        $data = $request->validate([
            'name'      => 'required|string|max:255',
            'parent_id' => 'int',
        ]);

        $department = Department::create($data);

        if($department) {
            return redirect()->route('admin.departments')->with(['status' => 'Success', 'message' => 'Successfully created department']);
        } else {
            return redirect()->route('admin.departments')->with(['status' => 'Error', 'message' => 'Error creating department']);
        }
    }

    public function destroyDepartment(Department $department) {
        $deletedDepartment = $department->delete();

        if($deletedDepartment) {
            return redirect()->route('admin.departments')->with(['status' => 'Success', 'message' => 'Successfully deleted department']);
        } else {
            return redirect()->route('admin.departments')->with(['status' => 'Error', 'message' => 'Error deleting department']);
        }
    }

    public function updateDepartment(Request $request, Department $department) {
        $data = $request->validate([
            'name'      => 'required|string|max:255',
        ]);

        $updatedDepartment = $department->update($data);

        if($updatedDepartment) {
            return redirect()->route('admin.departments')->with(['status' => 'Success', 'message' => 'Successfully updated department']);
        } else {
            return redirect()->route('admin.departments')->with(['status' => 'Error', 'message' => 'Error updating department']);
        }
    }

    public function designations(Request $request) {
        $designations = Designation::orderBy('position', 'desc')->get();

        $context = [
            'designations' => $designations,
            'breadcrumb'   => $request->breadcrumb,
        ];

        return Inertia::render('Admin/Designations', $context);
    }

    public function createDesignations(Request $request) {
        $data = $request->validate([
            'title' => 'required|string|max:255'
        ]);

        $nextPosition = Designation::max('position') + 1;

        $data['position'] = $nextPosition;

        $designation = Designation::create($data);

        if($designation) {
            return redirect()->route('admin.designations')->with(['status' => 'Success', 'message' => 'Successfully created designation']);
        } else {
            return redirect()->route('admin.designations')->with(['status' => 'Error', 'message' => 'Error creating designation']);
        }
    }

    public function destroyDesignation(Designation $designation) {
        $deletedDesignation = $designation->delete();

        if($deletedDesignation) {
            return redirect()->route('admin.designations')->with(['status' => 'Success', 'message' => 'Successfully deleted designation']);
        } else {
            return redirect()->route('admin.designations')->with(['status' => 'Error', 'message' => 'Error deleting designation']);
        }
    }

    public function updateDesignation(Request $request, Designation $designation) {
        $data = $request->validate([
            'title' => 'required|string|max:255'
        ]);

        $updatedDesignation = $designation->update($data);

        if($updatedDesignation) {
            return redirect()->route('admin.designations')->with(['status' => 'Success', 'message' => 'Successfully updated designation']);
        } else {
            return redirect()->route('admin.designations')->with(['status' => 'Error', 'message' => 'Error updating designation']);
        }
    }

    private function swapPositions(Designation $designation1, Designation $designation2)
    {
        $tempPosition = $designation1->position;
        $designation1->position = $designation2->position;
        $designation2->position = $tempPosition;

        $designation1->save();
        $designation2->save();
    }

    public function moveDesignationUp(Designation $designation)
    {
        $higherDesignation = Designation::where('position', '<', $designation->position)->orderBy('position', 'desc')->first();

        if ($higherDesignation) {
            $this->swapPositions($designation, $higherDesignation);
        }

        return redirect()->route('admin.designations')->with('success', 'Designation moved up successfully.');
    }

    public function moveDesignationDown(Designation $designation)
    {
        $lowerDesignation = Designation::where('position', '>', $designation->position)->orderBy('position', 'asc')->first();

        if ($lowerDesignation) {
            $this->swapPositions($designation, $lowerDesignation);
        }

        return redirect()->route('admin.designations')->with('success', 'Designation moved down successfully.');
    }

    public function structure(Request $request) {
        $breadcrumbs = Breadcrumb::with('children')->whereNull('parent_id')->get();

        // $directory = 

        $context = [
            'breadcrumbs' => $breadcrumbs,
            'breadcrumb'  => $request->breadcrumb,
        ];

        return Inertia::render('Admin/Structure', $context);
    }

    public function createStructure(Request $request) {
        $data = $request->validate([
            'name'      => 'required|string|max:255',
            'href'      => 'required|string|max:255',
            'parent_id' => 'int'
        ]);

        $structure = Breadcrumb::create($data);

        if($structure) {
            return redirect()->route('admin.structure')->with(['status' => 'Success', 'message' => 'Successfully added page']);
        } else {
            return redirect()->route('admin.structure')->with(['status' => 'Error', 'message' => 'Error adding page']);
        }
    }

    public function destroyStructure(Breadcrumb $breadcrumb) {
        $deletedBreadcrumb = $breadcrumb->delete();

        if($deletedBreadcrumb) {
            return redirect()->route('admin.structure')->with(['status' => 'Success', 'message' => 'Successfully deleted page']);
        } else {
            return redirect()->route('admin.structure')->with(['status' => 'Error', 'message' => 'Error deleting page']);
        }
    }

    public function profile(Request $request) {
        $departments = Department::doesntHave('children')->get();
        $designations = Designation::orderBy('position', 'desc')->get();
        $service_type = ['P']
        $context = [
            'departments'   => $departments,
            'designations'  => $designations,
            'breadcrumb'    => $request->breadcrumb,
        ];

        return Inertia::render('Admin/SelfProfile', $context);
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
                return redirect()->route('admin.profile')->with(['status' => 'Success', 'message' => 'Successfully updated avatar']);
            } else {
                return redirect()->route('admin.profile')->with(['status' => 'Error', 'message' => 'Error updating avatar']);
            }
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
            return redirect()->route('admin.profile')->with(['status' => 'Success', 'message' => 'Successfully updated general information']);
        } else {
            return redirect()->route('admin.profile')->with(['status' => 'Error', 'message' => 'Error updating general information']);
        }
    }
}
