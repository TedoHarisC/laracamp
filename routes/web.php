<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UserController;
use App\Http\Controllers\User\CheckoutController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\User\DashboardController as UserDashboard;
use App\Http\Controllers\Admin\DashboardController as AdminDashboard;
use App\Http\Controllers\Admin\CheckoutController as AdminCheckout;
use App\Http\Controllers\Admin\DiscountController as AdminDiscount;

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
    return view('welcome');
})->name('welcome');

// Socialite Routes
Route::get('sign-in-google', [UserController::class, 'google'])->name('user.login.google');
Route::get('auth/google/callback', [UserController::class, 'handleProviderCallback'])->name('user.google.callback');

// Midtrans Routes
Route::get('payment/success', [CheckoutController::class, 'midtransCallback']);
Route::post('payment/success', [CheckoutController::class, 'midtransCallback']);

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    // Checkout Routes
    Route::get('checkout/success', [CheckoutController::class, 'success'])->name('checkout.success')->middleware('ensureUserRole:user');
    Route::get('checkout/{camp:slug}', [CheckoutController::class, 'create'])->name('checkout.create')->middleware('ensureUserRole:user');
    Route::post('checkout/{camp}', [CheckoutController::class, 'store'])->name('checkout.store')->middleware('ensureUserRole:user');

    // Dashboard
    Route::get('dashboard', [HomeController::class, 'dashboard'])->name('dashboard');

    // User Dashboard
    Route::prefix('user/dashboard')->namespace('User')->name('user.')->middleware('ensureUserRole:user')->group(function(){
        Route::get('/', [UserDashboard::class, 'index'])->name('dashboard');
    });

    // Admin Dashboard
    Route::prefix('admin/dashboard')->name('admin.')->middleware('ensureUserRole:admin')->group(function(){
        Route::get('/', [AdminDashboard::class, 'index'])->name('dashboard');

        //admin checkout
        Route::post('checkout/{checkout}', [AdminCheckout::class, 'update'])->name('checkout.update');
        
        //admin discount
        Route::resource('discount', AdminDiscount::class); 
    });
});

require __DIR__ . '/auth.php';
