<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\EmployeeController;

Route::middleware(['auth','role:employee'])->prefix('employee')->group(function () {
    Route::get('/dashboard',[EmployeeController::class,'dashboard'])->name('employee.dashboard');

    // Profile
    Route::get('/profile',               [EmployeeController::class,'profile'])->name('employee.profile');

    // Attendance
    Route::post('/clock-in',             [EmployeeController::class,'clockIn'])->name('employee.attendance.clockin');
    Route::post('/clock-out',            [EmployeeController::class,'clockOut'])->name('employee.attendance.clockout');

    // Lunch Booking
    Route::post('/book-lunch',           [EmployeeController::class,'placeLunchBooking'])->name('employee.lunchbooking.create');
    Route::post('/cancel-lunch',         [EmployeeController::class,'cancelLunchBooking'])->name('employee.lunchbooking.delete');

    // Leaves
    Route::get('/leave-management',      [EmployeeController::class,'leaveManagement'])->name('employee.leave.manage');
    Route::post('/request-leave',        [EmployeeController::class,'requestLeave'])->name('employee.leave.request');
    Route::post('/cancel-leave',         [EmployeeController::class,'cancelLeave'])->name('employee.leave.cancel');

    // Time Sheet
    Route::get('/time-sheet',            [EmployeeController::class,'timeSheet'])->name('employee.timesheet');
});