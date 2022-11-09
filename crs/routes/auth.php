<?php

use App\Models\User;
use App\Models\Department;
use App\Models\Designation;
use App\Models\CRS\Facility;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\PatientController;
use App\Http\Controllers\Auth\NewPasswordController;
use App\Http\Controllers\Auth\VerifyEmailController;
use App\Http\Controllers\Auth\RegisteredUserController;
use App\Http\Controllers\Auth\PasswordResetLinkController;
use App\Http\Controllers\Auth\ConfirmablePasswordController;
use App\Http\Controllers\Auth\AuthenticatedSessionController;
use App\Http\Controllers\Auth\EmailVerificationPromptController;
use App\Http\Controllers\Auth\EmailVerificationNotificationController;

Route::get('/login', [AuthenticatedSessionController::class, 'create'])
                ->middleware('guest')
                ->name('login');

Route::post('/login', [AuthenticatedSessionController::class, 'store'])
                ->middleware('guest');

Route::get('/forgot-password', [PasswordResetLinkController::class, 'create'])
                ->middleware('guest')
                ->name('password.request');

Route::post('/forgot-password', [PasswordResetLinkController::class, 'store'])
                ->middleware('guest')
                ->name('password.email');

Route::get('/reset-password/{token}', [NewPasswordController::class, 'create'])
                ->middleware('guest')
                ->name('password.reset');

Route::post('/reset-password', [NewPasswordController::class, 'store'])
                ->middleware('guest')
                ->name('password.update');

Route::get('/verify-email', [EmailVerificationPromptController::class, '__invoke'])
                ->middleware('auth')
                ->name('verification.notice');

Route::get('/verify-email/{id}/{hash}', [VerifyEmailController::class, '__invoke'])
                ->middleware(['auth', 'signed', 'throttle:6,1'])
                ->name('verification.verify');

Route::post('/email/verification-notification', [EmailVerificationNotificationController::class, 'store'])
                ->middleware(['auth', 'throttle:6,1'])
                ->name('verification.send');

Route::get('/confirm-password', [ConfirmablePasswordController::class, 'show'])
                ->middleware('auth','prevent-back-history')
                ->name('password.confirm');

Route::post('/confirm-password', [ConfirmablePasswordController::class, 'store'])
                ->middleware('auth','prevent-back-history');

Route::post('/logout', [AuthenticatedSessionController::class, 'destroy'])
                ->middleware('auth')
                ->name('logout');

Route::group(['prefix' => 'user','middleware' => ['auth']], function(){
    Route::get('account',function () { 
        $user=User::addSelect([
            'department_name' => Department::select('department_name')->whereColumn('department_id', 'departments.id'),
            'designation_name' => Designation::select('name')->whereColumn('designation_id', 'designations.id'),
            ])->with('facility','facility.parent')->where('id',auth()->user()->id)->latest()->first();
            
        return view('admin.userAccount',compact('user'));})->name('user.account');
});

Route::group(['prefix' => 'admin','middleware' => ['auth','prevent-back-history']], function(){
    // Route::get('dashboard',function () { return view('super-admin.dashboard');})->name('super.dashboard');
    Route::get('/users/logs', function () 
    { 
        $logs =LogActivity::logActivityLists();
        return view('admin.logActivity',compact('logs'));

    })->middleware(['auth'])->name('logs');
    Route::get('patient/detail/{pat_no}',[PatientController::class,'getPatient'])->name('patient.get');
    Route::resource('users',RegisteredUserController::class);
    
});