<?php

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AdminController;

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
Route::get('/', function(){
    return redirect()->route('login');
});






Route::prefix('admin')->group(function(){
    Route::get('', [AdminController::class , 'index'])->name('admin-index');
    Route::prefix('memberships')->group(function(){
        Route::get('', [AdminController::class , 'shipsIndex'])->name('membership-index');
        Route::post('', [AdminController::class , 'shipsStore'])->name('membership-store');
        Route::post('active/{id}', [AdminController::class , 'shipsActive'])->name('membership-active');
        Route::post('inactive/{id}', [AdminController::class , 'shipsInactive'])->name('membership-inactive');
        Route::get('get-membership/{id}', [AdminController::class , 'getMembership']);
        Route::post('update', [AdminController::class , 'shipsUpdate'])->name('membership-update');
        Route::post('delete', [AdminController::class , 'shipsDelete'])->name('membership-delete');
    });
    Route::prefix('specializations')->group(function(){
        Route::get('', [AdminController::class , 'specializationIndex'])->name('specialization-index');
        Route::post('', [AdminController::class , 'specializationStore'])->name('specialization-store');
        Route::post('active/{id}', [AdminController::class , 'specializationActive'])->name('specialization-active');
        Route::post('inactive/{id}', [AdminController::class , 'specializationInactive'])->name('specialization-inactive');
        Route::get('get-specialization/{id}', [AdminController::class , 'getSpecialization']);
        Route::post('update', [AdminController::class , 'specializationUpdate'])->name('specialization-update');
        Route::post('delete', [AdminController::class , 'specializationDelete'])->name('specialization-delete');
    });
    Route::prefix('trainer')->group(function(){
        Route::get('', [AdminController::class , 'trainerIndex'])->name('trainers-index');
        Route::post('', [AdminController::class , 'trainerStore'])->name('trainers-store');
        Route::get('get-trainer-spec/{id}', [AdminController::class , 'getTrainerSpec']);
        Route::get('get-trainer/{id}', [AdminController::class , 'getTrainer']);
        Route::post('update', [AdminController::class , 'trainerUpdate'])->name('trainer-update');
        Route::post('delete', [AdminController::class , 'trainerDelete'])->name('trainer-delete');
    });

    Route::prefix('classes')->group(function(){
        Route::get('', [AdminController::class , 'classesIndex'])->name('classes-index');
        Route::post('', [AdminController::class , 'classesStore'])->name('classes-store');
        Route::get('/get-classes/{id}', [AdminController::class, 'getClasses']);
    });

    Route::prefix('members')->group(function(){
        Route::get('', [AdminController::class , 'membersIndex'])->name('members-index');
        Route::post('', [AdminController::class , 'membersStore'])->name('members-store');
        Route::get('search', [AdminController::class , 'membersSearch'])->name('members-search');
        Route::get('details/{id}', [AdminController::class , 'memberDetails'])->name('member-details');
        Route::post('delete/{id}', [AdminController::class , 'memberDelete'])->name('member-delete');
        Route::post('update/{id}', [AdminController::class , 'memberUpdate'])->name('member-update');
    });

    Route::prefix('payments')->group(function(){
        Route::get('', [AdminController::class , 'paymentIndex'])->name('payment-index');
        Route::post('update/payment/{id}', [AdminController::class , 'updatePayment'])->name('update-payment');
    });

    Route::prefix('transactions')->group(function(){
        Route::get('', [AdminController::class , 'transactionIndex'])->name('transaction-index');
        Route::post('', [AdminController::class , 'transactionStore'])->name('transaction-store');
        Route::get('get-member/{id}', [AdminController::class , 'getMember']);
    });

    
    Route::prefix('enrollments')->group(function(){
        Route::get('', [AdminController::class , 'enrollIndex'])->name('enrollment-index');
        Route::post('', [AdminController::class , 'enrollmentStore'])->name('enrollment-store');
        Route::get('get-enrollment/{id}', [AdminController::class , 'getEnrollment']);
        Route::post('delete', [AdminController::class , 'enrollmentDelete'])->name('enrollment-delete');
    });

});


Route::middleware([
    'auth:sanctum',
    config('jetstream.auth_session'),
    'verified',
])->group(function () {
    Route::get('/dashboard', function () {
        if(Auth::User()->role == 0){
            return redirect()->route('admin-index');
        }else{
            return abort('404', "We Don't Have Any WebPage To show you");
        }
    })->name('dashboard');
});