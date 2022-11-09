<?php

use App\Models\User;
use App\Models\Department;
use App\Models\ActivityLog;
use App\Models\Designation;
use App\Helpers\LogActivity;
use App\Models\CRS\Facility;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\CRS\KitController;
use App\Http\Controllers\DepartmentController;
use App\Http\Controllers\CRS\SwabberController;
use App\Http\Controllers\DesignationController;
use App\Http\Controllers\CRS\FacilityController;
use App\Http\Controllers\CRS\PlatformController;
use App\Http\Controllers\CRS\WagonjwaController;
use App\Http\Controllers\CRS\patientListController;
use App\Http\Controllers\CRS\ActivityTrailController;
use App\Http\Controllers\CRS\patientResultsController;
use App\Http\Controllers\CRS\ReportController;
use App\Http\Controllers\CRS\NotificationController;

use App\Http\Controllers\UsersController;
use App\Http\Controllers\RolesController;
use App\Http\Controllers\PermissionController;

use App\Http\Controllers\Auth\RegisteredUserController;
use App\Http\Controllers\Auth\AuthenticatedSessionController;

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

Route::get('/',[AuthenticatedSessionController::class, 'home'])->middleware('guest')->name('home');
Route::group(['middleware' => ['auth']], function(){
Route::get('/sendemail',[RegisteredUserController::class, 'send_email'])->middleware(['auth'])->name('sendemail');
Route::get('/management/dashboard',[RegisteredUserController::class, 'index'])->middleware(['auth'])->name('manage.index');
// Route::get('management/dashboard', function () { return redirect()->back()->with('error','Oops! Request could not be completed, Something went wrong');})->name('manage.index');
//-------------------------------DEPARTMENT MANAGEMENT ROUTES------------------------
Route::resource('departments',DepartmentController::class);
//-------------------------------DESIGNATION MANAGEMENT ROUTES-----------------------
Route::resource('designations',DesignationController::class);
//-------------------------------FACILITY MANAGEMENT ROUTES------------------------
Route::resource('facilities',FacilityController::class);
//-------------------------------PLATFORM MANAGEMENT ROUTES------------------------
Route::get('platformkits/{id}',[PlatformController::class, 'get_kits'])->name('kits.get');
Route::resource('platforms',PlatformController::class);
//-------------------------------KITS MANAGEMENT ROUTES------------------------
// Route::get('testtypes/{id}/list',[TestTypeController::class, 'getTypes'])->name('testtypes.get');
Route::resource('kits',KitController::class);
//-------------------------------ACTIVITY TRAIL MANAGEMENT ROUTES------------------------
Route::resource('activitytrails',ActivityTrailController::class);
//-------------------------------PATIENT MANAGEMENT ROUTES------------------------
Route::get('dashboard', [WagonjwaController::class, 'dashboard_show'])->name('dashboard');
// Route::get('testingfacility/results', [WagonjwaController::class, 'dashboard_show']);
Route::get('patients/results', [WagonjwaController::class, 'result']);
Route::get('patients/lab', [WagonjwaController::class, 'indexLab']);

Route::get('management/patients/manage', [WagonjwaController::class, 'ManagePatients']);

Route::get('patients/lab/today', [WagonjwaController::class, 'indexToday']);
Route::get('patients/lab/yesterday', [WagonjwaController::class, 'indexYesterday']);
Route::get('patients/lab/months', [WagonjwaController::class, 'indexMonths']);
Route::get('patients/lab/lastmonth', [WagonjwaController::class, 'indexLastMonths']);
Route::get('patients/lab/week', [WagonjwaController::class, 'indexWeek']);
Route::get('patients/lab/emergencies', [WagonjwaController::class, 'indexEmergency']);
Route::get('patients/lab/filter', [WagonjwaController::class, 'indexFilter']);

Route::get('patients/today', [WagonjwaController::class, 'indexTodayC']);
Route::get('patients/months', [WagonjwaController::class, 'indexMonthsC']);
Route::get('patients/week', [WagonjwaController::class, 'indexWeekC']);
Route::get('patients/filter', [WagonjwaController::class, 'indexFilterC']);

Route::get('patients/cancel/{id}', [WagonjwaController::class, 'cancelSample']);
Route::get('lab/patients/cancel/{id}', [WagonjwaController::class, 'AdmincancelSample']);

Route::get('patients/lab/result/imports', [patientResultsController::class, 'importBatchs']);

Route::get('patients/lab/result/pending', [patientResultsController::class, 'pending']);
Route::get('patients/lab/result/pending/{id}', [patientResultsController::class, 'pendingImport']);
Route::get('patients/lab/result/import/{id}', [patientResultsController::class, 'resultImport']);
Route::get('patients/lab/result/submitted', [patientResultsController::class, 'submitted']);
Route::get('patients/lab/result', [patientResultsController::class, 'index']);
Route::get('patients/lab/result/today', [patientResultsController::class, 'results_today']);
Route::get('patients/lab/result/yesterday', [patientResultsController::class, 'results_yesterday']);
Route::get('patients/lab/result/week', [patientResultsController::class, 'results_this_week']);
Route::get('patients/result/months', [patientResultsController::class, 'results_this_month']);
Route::get('patients/result/print/{id}', [patientResultsController::class, 'print']);

Route::get('/layout', function () {
    return view('crs.layouts.newlayout');
});

Route::get('patients/complete/{id}', [WagonjwaController::class, 'rdsComplete']);

Route::get('patients/lab/completed/today', [patientResultsController::class, 'completed_today']);
Route::get('patients/lab/completed/week', [patientResultsController::class, 'completed_this_week']);
Route::get('patients/lab/completed/months', [patientResultsController::class, 'completed_this_months']);
Route::get('patients/lab/result/completed', [patientResultsController::class, 'completed']);

Route::get('patients/lab/submitted/today', [patientResultsController::class, 'submitted_today']);
Route::get('patients/lab/submitted/week', [patientResultsController::class, 'submitted_this_week']);
Route::get('patients/submitted//months', [patientResultsController::class, 'submitted_this_month']);

//==============================reports==================================================
Route::get('patients/lab/export/{id}', [patientListController::class, 'exportPatient']);
Route::post('patients/export', [patientListController::class, 'exportPatientAll']);

Route::get('patients/labr/export/{value}', [patientListController::class, 'exportPendingResults']);

Route::post('patient/results/import', [WagonjwaController::class, 'import']);

Route::post('lab/report/result', [ReportController::class, 'patientresults']);
Route::post('lab/report/platifoms', [ReportController::class, 'platiform']);

Route::get('lab/report/moh', [ReportController::class, 'moh']);


Route::get('lab/report/Patienttat', [ReportController::class, 'AvgtatSingle']);
Route::get('lab/report/tat', [ReportController::class, 'Avgtat']);
Route::get('lab/report/patients', [ReportController::class, 'index']);

Route::post('lab/report/parentList', [ReportController::class, 'parentList']);

Route::get('patient/find', [ReportController::class, 'search']);
Route::post('lab/report/patients', [ReportController::class, 'LabfacilityPatients']);
Route::post('lab/report/patients/count', [ReportController::class, 'LabfacilityPatientsCount']);
Route::post('lab/report/entries', [ReportController::class, 'LabUserEntries']);
Route::post('lab/report/entries/count', [ReportController::class, 'LabUserEntryCount']);


//===============================all pending==============================================
Route::get('patients/lab/pending', [patientListController::class, 'pending']);
Route::get('patients/lab/pending/today', [patientListController::class, 'pending_today']);
Route::get('patients/lab/pending/yesterday', [patientListController::class, 'pending_yesterday']);
Route::get('patients/lab/pending/week', [patientListController::class, 'pending_this_week']);
Route::get('patients/lab/pending/months', [patientListController::class, 'pending_this_month']);

//===============================all pending==============================================
Route::get('patients/lab/accessioned', [patientListController::class, 'accessioned']);
Route::get('patients/lab/accessioned/today', [patientListController::class, 'accessioned_today']);
Route::get('patients/lab/accessioned/yesterday', [patientListController::class, 'accessioned_yesterday']);
Route::get('patients/lab/accessioned/week', [patientListController::class, 'accessioned_this_week']);
Route::get('patients/lab/accessioned/months', [patientListController::class, 'accessioned_this_month']);

Route::get('patients/lab/Allvalidated', [patientListController::class, 'validatedates']);

//===============================all pending==============================================
Route::get('patients/lab/validated', [patientListController::class, 'validated']);
Route::get('patients/lab/validated/today', [patientListController::class, 'validated_today']);
Route::get('patients/lab/validated/yesterday', [patientListController::class, 'validated_yesterday']);
Route::get('patients/lab/validated/week', [patientListController::class, 'validated_this_week']);
Route::get('patients/lab/validated/months', [patientListController::class, 'validated_this_month']);


Route::get('admin/lab/validate/{id}', [WagonjwaController::class, 'AdminvalidateLab']);
Route::post('admin/lab/update/{id}', [WagonjwaController::class, 'AdminUpdatePatient']);

Route::get('admin/manage/results/{id}', [WagonjwaController::class, 'AdminEditResults']);
Route::post('admin/results/update/{id}', [WagonjwaController::class, 'AdimUpdateResults']);

  Route::resource('assignment', UsersController::class);
    Route::resource('permission', PermissionController::class);
    Route::resource('roles', RolesController::class);


Route::get('lab/notification/view/{id}', [NotificationController::class, 'show']);

Route::get('wagonjwa/export',[WagonjwaController::class,'export'])->name('wagonjwa.export');
Route::get('mugonjwa/{id}', [WagonjwaController::class, 'send_to_rds'])->name('send.rds');
Route::get('patients/lab/new_patient', [WagonjwaController::class, 'createLab']);
Route::get('patients/lab/edit/{id}', [WagonjwaController::class, 'editLab']);
Route::get('patients/view/{id}', [WagonjwaController::class, 'showpatient']);
Route::get('patients/lab/validate/{id}', [WagonjwaController::class, 'validateLab']);
Route::post('patient/lab/number/{id}', [WagonjwaController::class, 'updateLab']);
Route::post('patient/lab/update/{id}', [WagonjwaController::class, 'updatePatientLab']);
Route::post('patient/lab/result/update/{id}', [WagonjwaController::class, 'updateLabResults']);
Route::get('patients/lab/delete/{id}', [WagonjwaController::class, 'destroyPatientLab']);
Route::resource('patients',WagonjwaController::class);
Route::get('facilityswabbers/{id}',[SwabberController::class, 'get_swabbers'])->name('swabbers.get');
Route::resource('swabbers',SwabberController::class);
});
require __DIR__.'/auth.php';



