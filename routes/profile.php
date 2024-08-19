<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ProfileController;

Route::middleware(['auth'])->group(function () {

    Route::get('/profile',                [ProfileController::class,'selfProfile'])->name('profile.self');
    Route::post('/change-profile-image',  [ProfileController::class,'changeProfilePicture'])->name('profile.avatar.update');
    Route::post('/update-general-info',   [ProfileController::class,'updateGeneralInformation'])->name('profile.general.update');
    Route::post('/update-job-details',    [ProfileController::class,'updateJobDetails'])->name('profile.jobdetail.update');
    Route::post('/update-personal-info',  [ProfileController::class,'updatePersonalInformation'])->name('profile.personal.update');

});