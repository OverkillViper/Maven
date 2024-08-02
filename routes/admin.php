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
    Route::get('/structure',                     [AdminController::class,'structure'])->name('admin.structure');
    Route::post('/structure/create',             [AdminController::class,'createStructure'])->name('admin.structure.create');
    Route::get('/structure/{breadcrumb}/delete', [AdminController::class,'destroyStructure'])->name('admin.structure.delete');

    // Profile
    Route::get('/profile',                       [AdminController::class,'profile'])->name('admin.profile');
    Route::post('/change-profile-image',         [AdminController::class,'changeProfilePicture'])->name('admin.profile.avatar.update');
    Route::post('/update-general-info',          [AdminController::class,'updateGeneralInformation'])->name('admin.profile.general.update');
});