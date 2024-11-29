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
        Route::post('active/{id}', [AdminController::class , 'shipsActive'])->name('membership-active');
        Route::post('inactive/{id}', [AdminController::class , 'shipsInactive'])->name('membership-inactive');
    });
    Route::prefix('trainer')->group(function(){
        Route::get('', [AdminController::class , 'trainerIndex'])->name('trainers-index');
        Route::post('', [AdminController::class , 'trainerStore'])->name('trainers-store');
        Route::get('get-trainer/{id}', [AdminController::class , 'getTrainer']);
    });

    Route::prefix('classes')->group(function(){
        Route::get('', [AdminController::class , 'classesIndex'])->name('classes-index');
        Route::post('', [AdminController::class , 'classesStore'])->name('classes-store');
    });

    Route::prefix('members')->group(function(){
        Route::get('', [AdminController::class , 'membersIndex'])->name('members-index');
        Route::post('', [AdminController::class , 'membersStore'])->name('members-store');
    });

    Route::prefix('payments')->group(function(){
        Route::get('', [AdminController::class , 'paymentIndex'])->name('payment-index');
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