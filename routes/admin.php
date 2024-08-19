<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AdminController;

Route::middleware(['auth','role:admin'])->prefix('admin')->group(function () {
    Route::get('/dashboard',[AdminController::class,'dashboard'])->name('admin.dashboard');

    // Departments
    Route::get('/departments',                     [AdminController::class,'departments'])->name('admin.departments');
    Route::post('/department/create',              [AdminController::class,'createDepartment'])->name('admin.department.create');
    Route::post('/department/{department}/delete', [AdminController::class,'destroyDepartment'])->name('admin.department.delete');
    Route::put('/department/{department}/update',  [AdminController::class,'updateDepartment'])->name('admin.department.update');

    // Designations
    Route::get('/designations',                      [AdminController::class,'designations'])->name('admin.designations');
    Route::post('/designation/create',               [AdminController::class,'createDesignations'])->name('admin.designation.create');
    Route::post('/designation/{designation}/delete', [AdminController::class,'destroyDesignation'])->name('admin.designation.delete');
    Route::put('/designation/{designation}/update',  [AdminController::class,'updateDesignation'])->name('admin.designation.update');
    Route::post('/designation/{designation}/moveup',   [AdminController::class,'moveDesignationUp'])->name('admin.designation.moveup');
    Route::post('/designation/{designation}/movedown', [AdminController::class,'moveDesignationDown'])->name('admin.designation.movedown');

    // Structure
    Route::get('/structure',                      [AdminController::class,'structure'])->name('admin.structure');
    Route::post('/structure/create',              [AdminController::class,'createStructure'])->name('admin.structure.create');
    Route::post('/structure/{breadcrumb}/delete', [AdminController::class,'destroyStructure'])->name('admin.structure.delete');

    // Profile
    Route::get('/profile',                       [AdminController::class,'profile'])->name('admin.profile');

    // Employees
    Route::get('/employee',                              [AdminController::class,'employee'])->name('admin.employee');
    Route::post('/employee',                             [AdminController::class,'employee'])->name('admin.employee');
    Route::get('/employee/{user}/details',               [AdminController::class,'employeeDetails'])->name('admin.employee.details');
    Route::post('/employee/{user}/update-general-info',  [AdminController::class,'updateEmployeeGeneralInforamtion'])->name('admin.employee.profile.general.update');
    Route::post('/employee/{user}/update-job-details',   [AdminController::class,'updateEmployeeJobDetails'])->name('admin.employee.profile.jobdetails.update');

    // Leaves
    Route::get('/leaves',                                [AdminController::class,'leaves'])->name('admin.leaves');
    Route::post('/leaves',                               [AdminController::class,'leaves'])->name('admin.leaves');
    Route::get('/leaves/types',                          [AdminController::class,'leaveTypes'])->name('admin.leaves.types');
    Route::post('/leaves/types/create',                  [AdminController::class,'createLeaveType'])->name('admin.leaves.types.create');
    Route::post('/leaves/types/{leaveType}/update',      [AdminController::class,'updateLeaveType'])->name('admin.leaves.types.update');
    Route::post('/leaves/types/{leaveType}/delete',      [AdminController::class,'destroyLeaveType'])->name('admin.leaves.types.delete');
    Route::get('/leaves/employee/{user}',                [AdminController::class,'employeeLeaveDetails'])->name('admin.leaves.employee');
    Route::post('/leaves/leaveProfile/create',           [AdminController::class,'createLeaveProfile'])->name('admin.leaves.profile.create');
    Route::put('/leaves/leaveProfile/{user}/update',     [AdminController::class,'updateLeaveProfile'])->name('admin.leaves.profile.update');

    //Holidays
    Route::get('/holidays',                              [AdminController::class,'holidays'])->name('admin.leaves.holidays');
    Route::post('/holiday/create',                       [AdminController::class,'createHoliday'])->name('admin.leaves.holiday.create');
    Route::post('/holiday/{holiday}/delete',             [AdminController::class,'deleteHoliday'])->name('admin.leaves.holiday.delete');
    Route::put('/holiday/{holiday}/update',              [AdminController::class,'updateHoliday'])->name('admin.leaves.holiday.update');
});