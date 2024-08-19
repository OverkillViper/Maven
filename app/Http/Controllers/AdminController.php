<?php

namespace App\Http\Controllers;

use Inertia\Inertia;
use Illuminate\Http\Request;

use App\Models\Department;
use App\Models\Designation;
use App\Models\Holiday;
use App\Models\User;
use App\Models\Breadcrumb;
use App\Models\LeaveType;
use App\Models\Leave;


use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;

class AdminController extends Controller
{
    public function dashboard(Request $request) {
        return Inertia::render('Admin/Dashboard');
    }

    public function departments(Request $request) {
        $departments = Department::with('children')->whereNull('parent_id')->get();

        $context = [
            'departments' => $departments,
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
            return redirect()->route('admin.departments')->with(['status' => 'success', 'message' => 'Successfully created department']);
        } else {
            return redirect()->route('admin.departments')->with(['status' => 'error', 'message' => 'Error creating department']);
        }
    }

    public function destroyDepartment(Department $department) {
        $deletedDepartment = $department->delete();

        if($deletedDepartment) {
            return redirect()->route('admin.departments')->with(['status' => 'success', 'message' => 'Successfully deleted department']);
        } else {
            return redirect()->route('admin.departments')->with(['status' => 'error', 'message' => 'Error deleting department']);
        }
    }

    public function updateDepartment(Request $request, Department $department) {
        $data = $request->validate([
            'name'      => 'required|string|max:255',
        ]);

        $updatedDepartment = $department->update($data);

        if($updatedDepartment) {
            return redirect()->route('admin.departments')->with(['status' => 'success', 'message' => 'Successfully updated department']);
        } else {
            return redirect()->route('admin.departments')->with(['status' => 'error', 'message' => 'Error updating department']);
        }
    }

    public function designations(Request $request) {
        $designations = Designation::orderBy('position', 'desc')->get();

        $context = [
            'designations' => $designations,
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
            return redirect()->route('admin.designations')->with(['status' => 'success', 'message' => 'Successfully created designation']);
        } else {
            return redirect()->route('admin.designations')->with(['status' => 'error', 'message' => 'Error creating designation']);
        }
    }

    public function destroyDesignation(Designation $designation) {
        $deletedDesignation = $designation->delete();

        if($deletedDesignation) {
            return redirect()->route('admin.designations')->with(['status' => 'success', 'message' => 'Successfully deleted designation']);
        } else {
            return redirect()->route('admin.designations')->with(['status' => 'error', 'message' => 'Error deleting designation']);
        }
    }

    public function updateDesignation(Request $request, Designation $designation) {
        $data = $request->validate([
            'title' => 'required|string|max:255'
        ]);

        $updatedDesignation = $designation->update($data);

        if($updatedDesignation) {
            return redirect()->route('admin.designations')->with(['status' => 'success', 'message' => 'Successfully updated designation']);
        } else {
            return redirect()->route('admin.designations')->with(['status' => 'error', 'message' => 'Error updating designation']);
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

        return redirect()->route('admin.designations')->with(['status' => 'success', 'message' => 'Designation moved up successfully']);
    }

    public function moveDesignationDown(Designation $designation)
    {
        $lowerDesignation = Designation::where('position', '>', $designation->position)->orderBy('position', 'asc')->first();

        if ($lowerDesignation) {
            $this->swapPositions($designation, $lowerDesignation);
        }

        return redirect()->route('admin.designations')->with(['status' => 'success', 'message' => 'Designation moved down successfully']);
    }

    public function structure(Request $request) {
        $all_breadcrumbs = Breadcrumb::with('children')->whereNull('parent_id')->get();

        $context = [
            'all_breadcrumbs' => $all_breadcrumbs,
            // 'breadcrumb'      => $request->breadcrumb,
        ];

        return Inertia::render('Admin/Structure', $context);
    }

    public function createStructure(Request $request) {
        $data = $request->validate([
            'name'      => 'required|string|max:255',
            'href'      => 'required|string|max:255',
            'icon'      => 'required|string|max:255',
            'for_admin' => 'required|boolean',
            'parent_id' => 'int'
        ]);

        $parent_breadcrumb = Breadcrumb::find($request->parent_id);

        if($parent_breadcrumb) {
            $data['level'] = $parent_breadcrumb->level + 1;
        } else {
            $data['level'] = 0;
        }
        

        $structure = Breadcrumb::create($data);

        if($structure) {
            return redirect()->route('admin.structure')->with(['status' => 'success', 'message' => 'Successfully added page']);
        } else {
            return redirect()->route('admin.structure')->with(['status' => 'error', 'message' => 'Error adding page']);
        }
    }

    public function destroyStructure(Breadcrumb $breadcrumb) {
        $deletedBreadcrumb = $breadcrumb->delete();

        if($deletedBreadcrumb) {
            return redirect()->route('admin.structure')->with(['status' => 'success', 'message' => 'Successfully deleted page']);
        } else {
            return redirect()->route('admin.structure')->with(['status' => 'error', 'message' => 'Error deleting page']);
        }
    }

    public function profile(Request $request) {
        $departments  = Department::doesntHave('children')->get();
        $designations = Designation::orderBy('position', 'desc')->get();

        $context = [
            'departments'   => $departments,
            'designations'  => $designations,
            'breadcrumb'    => $request->breadcrumb,
        ];

        return Inertia::render('Admin/SelfProfile', $context);
    }
    
    private function searchEmployee($query) {
        if (is_null($query) || trim($query) === '') {
            return redirect()->route('admin.employee')->with(['status' => 'error', 'message' => 'Please enter search query']);
        }

        $users = User::where('isAdmin', false)
        ->where(function ($q) use ($query) {
            $q->where('first_name', 'LIKE', "%{$query}%")
              ->orWhere('last_name', 'LIKE', "%{$query}%")
              ->orWhereRaw("CONCAT(first_name, ' ', last_name) LIKE ?", ["%{$query}%"])
              ->orWhere('email', 'LIKE', "%{$query}%");
        })
        ->orWhereHas('employee', function ($q) use ($query) {
            $q->where('employee_id', 'LIKE', "%{$query}%")
              ->orWhereHas('department', function ($q) use ($query) {
                  $q->where('name', 'LIKE', "%{$query}%");
              })
              ->orWhereHas('designation', function ($q) use ($query) {
                  $q->where('title', 'LIKE', "%{$query}%");
              });
        })->with(['employee.department', 'employee.designation'])
        ->get();

        return $users;
    }

    public function employee(Request $request) {

        if($request->isMethod('post')) {
            $users = [];

            $query = $request->input('query');

            $users = $this->searchEmployee($query);

            $context = [
                'users' => $users,
            ];
    
            return Inertia::render('Admin/Employee', $context);
        } else {
            return Inertia::render('Admin/Employee');
        } 
    }
 
    public function employeeDetails(User $user) {

        $user->load(['employee.department', 'employee.designation']);
        $departments  = Department::doesntHave('children')->get();
        $designations = Designation::orderBy('position', 'desc')->get();

        $context = [
            'departments'  => $departments,
            'designations' => $designations,
            'user'         => $user,
        ];

        return Inertia::render('Admin/EmployeeDetails', $context);
    }

    public function updateEmployeeGeneralInforamtion(Request $request, User $user) {
        $data = $request->validate([
            'first_name' => 'required|string|max:255',
            'last_name'  => 'required|string|max:2551',
            'email'      => 'required|email',
        ]);

        $updatedUser = $user->update($data);

        if($updatedUser) {
            return redirect()->route('admin.employee.details', $user->id)->with(['status' => 'success', 'message' => 'Successfully updated general information']);
        } else {
            return redirect()->route('admin.employee.details', $user->id)->with(['status' => 'error', 'message' => 'Error updating general information']);
        }
    }

    public function updateEmployeeJobDetails(Request $request, User $user) {
        $joined_at    = $request->joined_at ? Carbon::parse($request->joined_at)->format('Y-m-d') : $request->joined_at;
        $permanent_at = $request->servicetype == 'Permanent' && $user->employee->servicetype == 'Probation' ? Carbon::parse(Carbon::now())->format('Y-m-d') : ($request->permanent_at ? Carbon::parse($request->permanent_at)->format('Y-m-d') : $request->permanent_at);

        $user->employee->employee_id    = $request->employee_id;
        $user->employee->department_id  = $request->input('department.id');
        $user->employee->designation_id = $request->input('designation.id');
        $user->employee->servicetype    = $request->servicetype;
        $user->employee->job_location   = $request->job_location;
        $user->employee->salary         = $request->salary;
        $user->employee->joined_at      = $joined_at;
        $user->employee->permanent_at   = $permanent_at;
        $updatedUser = $user->employee->save();

        if($updatedUser) {
            return redirect()->route('admin.employee.details', $user->id)->with(['status' => 'success', 'message' => 'Successfully updated employee']);
        } else {
            return redirect()->route('admin.employee.details', $user->id)->with(['status' => 'error', 'message' => 'Error updating employee']);
        }
    }

    public function holidays(Request $request) {
        $filterYear = $request->year;
        $thisYear = Carbon::now()->year;

        $year = $filterYear ?? $thisYear;

        $startOfYear = Carbon::create($year, 1, 1)->startOfDay();
        $endOfYear = Carbon::create($year, 12, 31)->endOfDay();

        $holidays = Holiday::whereBetween('date', [$startOfYear, $endOfYear])->orderBy('date', 'desc')->get();

        $context = [
            'holidays' => $holidays,
        ];

        return Inertia::render('Admin/Holidays', $context);
    }

    public function createHoliday(Request $request) {

        $data = $request->validate([
            'name' => 'required|string|max:255',
            'date' => 'required|date',
        ]);

        $date = Carbon::parse($data['date'])->addDay()->format('Y-m-d');

        $holiday = Holiday::create([
            'name' => $data['name'],
            'date' => $date,
        ]);

        if($holiday) {
            return redirect()->route('admin.holidays')->with(['status' => 'success', 'message' => 'Successfully created holiday']);
        } else {
            return redirect()->route('admin.holidays')->with(['status' => 'error', 'message' => 'Error creating holiday']);
        }
    }

    public function deleteHoliday(Holiday $holiday) {
        $deletedHoliday = $holiday->delete();

        if($deletedHoliday) {
            return redirect()->route('admin.holidays')->with(['status' => 'success', 'message' => 'Successfully deleted holiday']);
        } else {
            return redirect()->route('admin.holidays')->with(['status' => 'error',   'message' => 'Error deleting holiday']);
        }
    }

    public function updateHoliday(Request $request, Holiday $holiday) {
        $data = $request->validate([
            'name' => 'required|string|max:255',
            'date' => 'required|date',
        ]);
        
        $date = Carbon::parse($data['date'])->format('Y-m-d');

        if ($holiday->date != $date) {
            $date = Carbon::parse($data['date'])->addDay()->format('Y-m-d');
        }

        $updatedHoliday = $holiday->update([
            'name' => $data['name'],
            'date' => $date,
        ]);

        if($updatedHoliday) {
            return redirect()->route('admin.holidays')->with(['status' => 'success', 'message' => 'Successfully updated holiday']);
        } else {
            return redirect()->route('admin.holidays')->with(['status' => 'error',   'message' => 'Error updating holiday']);
        }
    }

    public function leaves(Request $request) {

        if($request->isMethod('post')) {
            $users = [];

            $query = $request->input('query');

            $users = $this->searchEmployee($query);

            $context = [
                'users' => $users,
            ];
    
            return Inertia::render('Admin/Leaves', $context);
        } else {
            return Inertia::render('Admin/Leaves');
        }
    }

    public function employeeLeaveDetails(User $user) {

        $user->load([
            'employee.department' => function ($query) {
                $query->with('parent');
            },
            'employee.designation',
            'leaves.type',
        ]);

        $departmentAncestors = $user->employee && $user->employee->department ? $user->employee->department->ancestors() : collect([]);
        $experience = $user->employee ? $user->employee->experience() : null;

        $leaves = Leave::where('user_id', '=', $user->id)->with('type')->get();

        $context = [
            'user'                  => $user,
            'departmentAncestors'   => $departmentAncestors ?? null,
            'experience'            => $experience ?? null,
            'leaves'                => $user->leaves,
        ];

        return Inertia::render('Admin/EmployeeLeaves', $context);
    }

    public function leaveTypes() {
        $leaveTypes = LeaveType::all();

        $context = [
            'leaveTypes' => $leaveTypes,
        ];

        return Inertia::render('Admin/LeaveTypes', $context);
    }

    public function createLeaveType(Request $request) {

        $data = $request->validate([
            'name' => 'required|string|max:255'
        ]);

        $leaveType = LeaveType::create($data);

        if($leaveType) {
            return redirect()->route('admin.leaves.types')->with(['status' => 'success', 'message' => 'Successfully created leave type']);
        } else {
            return redirect()->route('admin.leaves.types')->with(['status' => 'error',   'message' => 'Error creating leave type']);
        }
    }

    public function updateLeaveType(Request $request, LeaveType $leaveType) {
        $data = $request->validate([
            'name' => 'required|string|max:255'
        ]);

        $updatedLeaveType = $leaveType->update($data);

        if($updatedLeaveType) {
            return redirect()->route('admin.leaves.types')->with(['status' => 'success', 'message' => 'Successfully updated leave type']);
        } else {
            return redirect()->route('admin.leaves.types')->with(['status' => 'error',   'message' => 'Error updating leave type']);
        }
    }

    public function destroyLeaveType(LeaveType $leaveType) {
        $deletedLeaveType = $leaveType->delete();

        if($deletedLeaveType) {
            return redirect()->route('admin.leaves.types')->with(['status' => 'success', 'message' => 'Successfully deleted leave type']);
        } else {
            return redirect()->route('admin.leaves.types')->with(['status' => 'error',   'message' => 'Error deleting leave type']);
        }
    }

    public function createLeaveProfile(Request $request) {
        $leaveTypes = LeaveType::all();
        $user_id    = $request->user_id;

        foreach($leaveTypes as $type) {
            $leave = Leave::create([
                'user_id'    => $user_id,
                'type'       => $type->id,
                'allocation' => 0
            ]);

            if($leave == null) {
                return redirect()->route('admin.leaves.employee', $user_id)->with(['status' => 'error',   'message' => 'Error creating leave profile']);
            }
        }

        return redirect()->route('admin.leaves.employee', $user_id)->with(['status' => 'success',   'message' => 'Successfully created leave profile']);
    }

    public function updateLeaveProfile(Request $request, User $user) {
        $data = $request->validate([
            'leaves' => 'required|array',
            'leaves.*.id' => 'exists:leaves,id',
            'leaves.*.allocation' => 'required|integer|min:0',
        ]);

        $updatedLeave = null;
        
        foreach ($data['leaves'] as $leaveData) {
            $leave = Leave::findOrFail($leaveData['id']);
            $updatedLeave = $leave->update([
                'allocation' => $leaveData['allocation']
            ]);

            if($updatedLeave == null) {
                return redirect()->route('admin.leaves.employee', $user->id)->with(['status' => 'error', 'message' => 'Error updating leave profile']);
            }
        }

        return redirect()->route('admin.leaves.employee', $user->id)->with(['status' => 'success', 'message' => 'Successfully updated leave profile']);
    }
}
