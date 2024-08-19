<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Inertia\Inertia;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;
use App\Models\Attendance;
use App\Models\LunchBooking;
use App\Models\Leave;
use App\Models\LeaveType;
use App\Models\AppliedLeave;

class EmployeeController extends Controller
{

    private function getLunchBookings() {
        $user = Auth::user();
        $today = Carbon::today();
        
        // Fetch 3 days before, today, and 3 days after
        $dates = collect();
        for ($i = -3; $i <= 3; $i++) {
            $dates->push($today->copy()->addDays($i));
        }

        // Fetch bookings for these dates
        $bookings = LunchBooking::where('user_id', $user->id)
                    ->whereBetween('booking_date', [$today->copy()->subDays(3), $today->copy()->addDays(3)])
                    ->get();

        return [
            'dates' => $dates->map(function ($date) use ($bookings) {
                return [
                    'date' => $date->format('Y-m-d'),
                    'isBooked' => $bookings->contains('booking_date', $date->format('Y-m-d'))
                ];
            }),
        ];
    }

    private function getLeaveSummery() {
        $user = Auth::user();

        $leaveTypes = LeaveType::all();

        $leaveSummary = $leaveTypes->map(function ($leaveType) use ($user) {
            
            $leave = Leave::where('user_id', $user->id)
                          ->where('type', $leaveType->id)
                          ->first();

            $allocation = $leave ? $leave->allocation : 0;

            $utilized = AppliedLeave::where('user_id', $user->id)
                                    ->where('type', $leaveType->id)
                                    ->where('approved', true)
                                    ->count();

            $pending = AppliedLeave::where('user_id', $user->id)
                                   ->where('type', $leaveType->id)
                                   ->where('approved', false)
                                   ->count();

            $balance = $allocation - $utilized - $pending;

            return [
                'leaveType' => $leaveType->name,
                'allocation' => $allocation,
                'utilized' => $utilized,
                'pending' => $pending,
                'balance' => $balance,
            ];
        });

        return $leaveSummary;
    }

    public function dashboard(){

        $user = Auth::user();
        $today = Carbon::today();
        $tomorrow = Carbon::tomorrow()->toDateString();

        $attendance = Attendance::where('user_id', $user->id)
            ->whereDate('in_time', $today)
            ->first();
        
        $bookedTomorrow = LunchBooking::where('user_id', $user->id)
                                    ->whereDate('booking_date', $tomorrow)
                                    ->exists();
        $bookedToday    = LunchBooking::where('user_id', $user->id)
                                    ->whereDate('booking_date', $today)
                                    ->exists();

        $lunchBookingDates = $this->getLunchBookings();

        $leaveSummery = $this->getLeaveSummery();

        $context = [
            'attendance'        => $attendance,
            'lunchBookingDates' => $lunchBookingDates,
            'bookedTomorrow'    => $bookedTomorrow,
            'bookedToday'       => $bookedToday,
            'leaveSummery'      => $leaveSummery,
        ];

        return Inertia::render('Employee/Dashboard', $context);
    }

    public function profile() {

        return Inertia::render('Employee/SelfProfile');
    }

    public function clockIn() {

        $today = Carbon::today();
        $user = Auth::user();

        $existingAttendance = Attendance::where('user_id', $user->id)
                                        ->whereDate('in_time', $today)
                                        ->first();
        
        $clockInAttendance = null;

        if($existingAttendance) {
            return redirect()->route('employee.dashboard')->with(['status' => 'error', 'message' => 'You have already clocked in. Please request a time change']);
        } else {
            $clockInAttendance = Attendance::create([
                'in_time'  => Carbon::now(),
                'user_id'  => Auth::user()->id,
            ]);
        }

        if($clockInAttendance) {
            return redirect()->route('employee.dashboard')->with(['status' => 'success', 'message' => 'Successfully clocked in']);
        } else {
            return redirect()->route('employee.dashboard')->with(['status' => 'error', 'message' => 'Error clocking in']);
        }
    }

    public function clockOut() {
        $today = Carbon::today();
        $user = Auth::user();

        $existingAttendance = Attendance::where('user_id', $user->id)
                                        ->whereDate('in_time', $today)
                                        ->first();

        if($existingAttendance) {
            $clockedOutAttendance = $existingAttendance->update([
                'out_time' => Carbon::now(),
            ]);

            if($clockedOutAttendance) {
                return redirect()->route('employee.dashboard')->with(['status' => 'success', 'message' => 'Successfully clocked out']);
            } else {
                return redirect()->route('employee.dashboard')->with(['status' => 'error', 'message' => 'Error clocking out']);
            }
        } else {
            return redirect()->route('employee.dashboard')->with(['status' => 'error', 'message' => 'You have not clocked in yet. Please clock in first']);
        }
    }

    public function placeLunchBooking() {
        $user = Auth::user();

        // $tomorrow = Carbon::tomorrow();

        $lunchBooking = LunchBooking::create([
            'user_id'       => $user->id,
            'booking_date'  => Carbon::tomorrow(),
        ]);

        if($lunchBooking) {
            return redirect()->route('employee.dashboard')->with(['status' => 'success', 'message' => 'Successfully placed lunch booking']);
        } else {
            return redirect()->route('employee.dashboard')->with(['status' => 'error', 'message' => 'Error placing lunch booking']);
        }
    }

    public function cancelLunchBooking() {
        $user = Auth::user();

        $tomorrow = Carbon::tomorrow();

        $existingBooking = LunchBooking::where('user_id', $user->id)
                                       ->whereDate('booking_date', $tomorrow)
                                       ->first();

        $deletedBooking = $existingBooking->delete();

        if($deletedBooking) {
            return redirect()->route('employee.dashboard')->with(['status' => 'success', 'message' => 'Successfully canceled lunch booking']);
        } else {
            return redirect()->route('employee.dashboard')->with(['status' => 'error', 'message' => 'Error canceling booking']);
        }
    }

    public function leaveManagement(Request $request) {

        $user = Auth::user();

        $leaves         = Leave::where('user_id', '=', $user->id)->with('type')->get();

        $leaveSummery = $this->getLeaveSummery();
        $appliedLeaves = AppliedLeave::where('user_id', '=', $user->id)->with('type')->get();

        $filterYear = $request->year;
        $thisYear = Carbon::now()->year;

        $year = $filterYear ?? $thisYear;

        $startOfYear = Carbon::create($year, 1, 1)->startOfDay();
        $endOfYear = Carbon::create($year, 12, 31)->endOfDay();

        $pendingLeaves  = AppliedLeave::where('user_id', '=', $user->id)->whereBetween('date', [$startOfYear, $endOfYear])->where('approved', '=', false)->with('type')->orderBy('date', 'desc')->get();
        $approvedLeaves = AppliedLeave::where('user_id', '=', $user->id)->whereBetween('date', [$startOfYear, $endOfYear])->where('approved', '=', true)->with('type')->orderBy('date', 'desc')->get();

        $context = [
            'leaves'         => $leaves,
            'leaveSummery'   => $leaveSummery,
            'pendingLeaves'  => $pendingLeaves,
            'approvedLeaves' => $approvedLeaves,
            'year'           => $request->year,
        ];

        return Inertia::render('Employee/LeaveManagement', $context);
    }

    public function requestLeave(Request $request) {
        
        $user = Auth::user();
        
        $data = $request->validate([
            'type'   => 'required',
            'date'   => 'required',
            'reason' => 'required',
        ]);

        $leave = Leave::where('user_id', '=', $user->id)->where('type', '=', $request->type)->first();
        $leaveAllocation = $leave->allocation;

        $utilizedLeave = AppliedLeave::where('user_id', '=', $user->id)->where('type', '=', $request->type)->count();
        
        $leaveBalance = $leaveAllocation - $utilizedLeave;

        $startDate = Carbon::parse($request->date[0]);
        $endDate   = Carbon::parse($request->date[1]);

        $totalDays = $request->date[1] == null ? 1 : (int) $startDate->diffInDays($endDate);

        if($leaveBalance > $totalDays) {
            // $totalDays = $request->date[1] == null ? 1 : 
            for ($i=0; $i < $totalDays + 1; $i++) { 
                $appliedLeave = AppliedLeave::create([
                    'user_id'  => $user->id,
                    'type'     => $request->type,
                    'reason'   => $request->reason,
                    'date'     => $startDate->addDays(1),
                    'approved' => false,
                ]);

                if($appliedLeave == null) {
                    return redirect()->route('employee.leave.manage')->with(['status' => 'error', 'message' => 'Error placing leave request']);
                }
            }
            return redirect()->route('employee.leave.manage')->with(['status' => 'success', 'message' => 'Successfully placed leave request']);

        } else {
            return redirect()->route('employee.leave.manage')->with(['status' => 'error', 'message' => 'You do not have sufficient leave balance for selected leave type']);
        }
    }

    public function cancelLeave(Request $request) {

        $leave = AppliedLeave::findOrFail($request->leave);

        $deletedLeave = $leave->delete();

        if($deletedLeave) {
            return redirect()->back()->with(['status' => 'success', 'message' => 'Successfully cancelled leave request']);
        } else {
            return redirect()->back()->with(['status' => 'error', 'message' => 'Error canceling leave request']);
        }
    }

    public function timeSheet(Request $request) {

        $user = Auth::user();

        $startDate = null;
        $endDate = null;

        $totalDays = 0;
        $presentDays = 0;
        $absentDays = 0;

        if($request->dates) {
            $startDate = Carbon::parse($request->dates[0])->addDay();
            $endDate   = Carbon::parse($request->dates[1])->addDay();

            $totalDays = $request->dates[1] ? $startDate->diffInDays($endDate) + 1 : 0;
        }

        $attendances = [];

        if($request->dates[0] != null && $request->dates[1] != null) {
            for ($date = $startDate; $date->lte($endDate); $date->addDay()) {
                $attendance = Attendance::whereDate('in_time', $date->format('Y-m-d'))
                                        ->where('user_id', $user->id)
                                        ->first();
        
                if ($attendance) {
                    $attendances[] = [
                        'date' => $date->format('Y-m-d'),
                        'in_time' => $attendance->in_time,
                        'out_time' => $attendance->out_time ?? 'NC',
                    ];

                    $presentDays++;
                } else {
                    $attendances[] = [
                        'date' => $date->format('Y-m-d'),
                        'in_time' => 'N/A',
                        'out_time' => 'N/A',
                    ];
                }
            }
        }

        $context = [
            'attendances' => $attendances,
            'totalDays'   => $totalDays,
            'presentDays' => $presentDays,
            'absentDays'  => $totalDays - $presentDays,
        ];

        return Inertia::render('Employee/Attendance/TimeSheet', $context);
    }
}
