<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::get('/', function () {
    return redirect()->route('login');
})->name('/');




// Guest Users
Route::middleware(['guest','PreventBackHistory', 'firewall.all'])->group(function()
{
    Route::get('login', [App\Http\Controllers\Admin\AuthController::class, 'showLogin'] )->name('login');
    Route::post('login', [App\Http\Controllers\Admin\AuthController::class, 'login'])->name('signin');
    Route::get('register', [App\Http\Controllers\Admin\AuthController::class, 'showRegister'] )->name('register');
    Route::post('register', [App\Http\Controllers\Admin\AuthController::class, 'register'])->name('signup');

});




// Authenticated users
Route::middleware(['auth','PreventBackHistory', 'firewall.all'])->group(function()
{

    // Auth Routes
    Route::get('home', fn () => redirect()->route('dashboard'))->name('home');
    Route::get('dashboard', [App\Http\Controllers\Admin\DashboardController::class, 'index'])->name('dashboard');
    Route::post('logout', [App\Http\Controllers\Admin\AuthController::class, 'Logout'])->name('logout');
    Route::get('change-theme-mode', [App\Http\Controllers\Admin\DashboardController::class, 'changeThemeMode'])->name('change-theme-mode');
    Route::get('show-change-password', [App\Http\Controllers\Admin\AuthController::class, 'showChangePassword'] )->name('show-change-password');
    Route::post('change-password', [App\Http\Controllers\Admin\AuthController::class, 'changePassword'] )->name('change-password');



    // Masters
    Route::resource('wards', App\Http\Controllers\Admin\Masters\WardController::class );
    Route::resource('labs', App\Http\Controllers\Admin\Masters\LabController::class );
    Route::resource('maincategories', App\Http\Controllers\Admin\Masters\MainCategoryController::class );
    Route::resource('subcategories', App\Http\Controllers\Admin\Masters\SubCategoryController::class );
    Route::resource('methods', App\Http\Controllers\Admin\Masters\MethodController::class );





    // Users Roles n Permissions
    Route::resource('users', App\Http\Controllers\Admin\UserController::class );
    Route::get('users/{user}/toggle', [App\Http\Controllers\Admin\UserController::class, 'toggle' ])->name('users.toggle');
    Route::get('users/{user}/retire', [App\Http\Controllers\Admin\UserController::class, 'retire' ])->name('users.retire');
    Route::put('users/{user}/change-password', [App\Http\Controllers\Admin\UserController::class, 'changePassword' ])->name('users.change-password');
    Route::get('users/{user}/get-role', [App\Http\Controllers\Admin\UserController::class, 'getRole' ])->name('users.get-role');
    Route::put('users/{user}/assign-role', [App\Http\Controllers\Admin\UserController::class, 'assignRole' ])->name('users.assign-role');
    Route::resource('roles', App\Http\Controllers\Admin\RoleController::class );

    // patient registration
    Route::get('patient-registration-list', [App\Http\Controllers\PatientController::class, 'index'])->name('register.patient.list');
    Route::get('register-patient', [App\Http\Controllers\PatientController::class, 'create'])->name('register.patient.create');
    Route::post('patient-store', [App\Http\Controllers\PatientController::class, 'store'])->name('store.patient');
    Route::get('patient-edit/{id}', [App\Http\Controllers\PatientController::class, 'edit'])->name('edit.patient');
    Route::get('patient-view/{id}', [App\Http\Controllers\PatientController::class, 'view'])->name('view.patient');
    Route::put('patient-update/{id}', [App\Http\Controllers\PatientController::class, 'update'])->name('update.patient');
    Route::delete('patient-delete/{id}', [App\Http\Controllers\PatientController::class, 'destroy'])->name('delete.patient');

    // pending for receive
    Route::get('pending-for-receive-list', [App\Http\Controllers\PatientController::class, 'pending_for_receive_list'])->name('pending_for_receive.patient');
    Route::get('patient-details/{patient}', [App\Http\Controllers\PatientController::class, 'patientDetails'])->name('patient.details');


    // rejected List
    Route::get('rejeted-sample-list', [App\Http\Controllers\PatientController::class, 'rejected_sample_list'])->name('rejected_sample_list');
    // received sample
    Route::get('received-sample-list', [App\Http\Controllers\PatientController::class, 'received_sample_list'])->name('received_sample_list');
    Route::put('patient-received/{id}', [App\Http\Controllers\PatientController::class, 'update_status_received'])->name('received.patient');
    Route::put('approve-status/{id}', [App\Http\Controllers\PatientController::class, 'approved_status'])->name('approve.status');
    Route::put('reject-status/{id}', [App\Http\Controllers\PatientController::class, 'reject_status'])->name('reject.status');

    // approved sample list
    Route::get('approved-sample-list', [App\Http\Controllers\PatientController::class, 'approved_sample_list'])->name('approved_sample_list');

    // enter parameter
    Route::get('add-parameter/{id}', [App\Http\Controllers\PatientController::class, 'put_parameter'])->name('enter.patientParameter');
    Route::post('/store-results/{id}', [App\Http\Controllers\PatientController::class, 'storeResults'])->name('store.results');

    // first verification list
    Route::get('first-verification-list', [App\Http\Controllers\PatientController::class, 'first_verification_list'])->name('first_verification_list');
    Route::get('view-patient-parameter/{id}', [App\Http\Controllers\PatientController::class, 'view_patient_parameter'])->name('view.patientParameter');
    Route::put('first-doctor-approve-status/{id}', [App\Http\Controllers\PatientController::class, 'first_doctor_approved_status'])->name('firstDoctor.approve.status');
    Route::put('first-doctor-reject-status/{id}', [App\Http\Controllers\PatientController::class, 'first_doctor_reject_status'])->name('firstDoctor.reject.status');

    // second verification list
    Route::get('second-verification-list', [App\Http\Controllers\PatientController::class, 'second_verification_list'])->name('second_verification_list');
    Route::put('second-doctor-approve-status/{id}', [App\Http\Controllers\PatientController::class, 'second_doctor_approved_status'])->name('secondDoctor.approve.status');
    Route::put('second-doctor-reject-status/{id}', [App\Http\Controllers\PatientController::class, 'second_doctor_reject_status'])->name('secondDoctor.reject.status');

    // doctor rejected list
    Route::get('doctor-rejected-list', [App\Http\Controllers\PatientController::class, 'doctor_rejected_list'])->name('doctor_rejected_list');

    // generated report list
    Route::get('generated-report-list', [App\Http\Controllers\PatientController::class, 'generated_report_list'])->name('generated_report_list');

    // testpdf

    Route::get('/testreport/{id}', [App\Http\Controllers\PatientController::class, 'testReportPdf']);
    Route::post('/get-labs', [App\Http\Controllers\PatientController::class, 'getLabs'])->name('get.labs');

    Route::post('/send-sms', [App\Http\Controllers\SendSMSController::class, 'sendSms'])->name('send.sms');

});




Route::get('/php', function(Request $request){
    if( !auth()->check() )
        return 'Unauthorized request';

    Artisan::call($request->artisan);
    return dd(Artisan::output());
});
