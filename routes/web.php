<?php

use App\Http\Controllers\AirtimeController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\BillController;
use App\Http\Controllers\BusniessController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\Transaction1Controller;
use App\Http\Controllers\VertualController;
use Illuminate\Support\Facades\Auth;
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
    return view('auth.login');
});

Route::middleware([
    'auth:sanctum',
    config('jetstream.auth_session'),
    'verified',
])->group(function () {

    Route::get('dashboard', [DashboardController::class, 'loaddashboard'])->name('dashboard');
    Route::get('wallet', [DashboardController::class, 'mywallet'])->name('wallet');
    Route::get('trans', [Transaction1Controller::class, 'mytransaction'])->name('trans');

    Route::get('/transaction', [Transaction1Controller::class, 'getTransactions']);
    Route::get('/transaction1', [Transaction1Controller::class, 'getTransactions1']);

    Route::get('myaccount', [DashboardController::class, 'myaccount'])->name('myaccount');

    Route::post('update', [BusniessController::class, 'updateprofile'])->name('update');
    Route::post('updates', [BusniessController::class, 'updatebusiness'])->name('updates');

    Route::get('allvirtual', [Transaction1Controller::class, 'myvirtualaccount'])->name('allvirtual');
    Route::get('credentials', [BusniessController::class, 'apicredential'])->name('credentials');

    Route::post('updateweb', [BusniessController::class, 'updatewebhook'])->name('updateweb');

    Route::get('airtime', [AirtimeController::class, 'loadindex'])->name('airtime');
    Route::get('redata/{selectedValue}', [AuthController::class, 'redata'])->name('redata');
    Route::post('bill', [BillController::class, 'bill'])->name('bill');
    Route::get('select', [AuthController::class, 'select'])->name('select');
    Route::get('allbill', [BillController::class, 'allbils'])->name('allbill');
    Route::post('buyairtime', [AirtimeController::class, 'airtime'])->name('buyairtime');

    Route::get('virtual', [VertualController::class, 'vertual'])->name('virtual');


});
Route::get('/logout', function(){
    Auth::logout();
    return redirect('login')->with('status', 'logout successful');
});
