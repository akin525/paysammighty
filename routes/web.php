<?php

use App\Http\Controllers\admin\CandCController;
use App\Http\Controllers\admin\LoginController;
use App\Http\Controllers\admin\ReportController;
use App\Http\Controllers\admin\UsersController;
use App\Http\Controllers\AirtimeController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\BillController;
use App\Http\Controllers\BusniessController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\Transaction1Controller;
use App\Http\Controllers\VertualController;
use App\Http\Controllers\WithdrawController;
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
    Route::get('verifyacct/{value1}/{value2}', [WithdrawController::class, 'verifyaccount'])->name('verifyacct');

    Route::get('withdraw', [WithdrawController::class, 'allbank'])->name('withdraw');

    Route::post('rbonus', [WithdrawController::class, 'confirmto'])->name('rbonus');
    Route::post('withdrawnow', [WithdrawController::class, 'withdraw'])->name('withdrawnow');

    Route::get('alledu', [\App\Http\Controllers\EduController::class, 'alledulist'])->name('alledu');

    Route::get('bvn', [\App\Http\Controllers\BankController::class, 'checkbvn'])->name('bvn');
    Route::post('updatebvn', [\App\Http\Controllers\BankController::class, 'updatekbvn'])->name('updatebvn');
});
Route::get('/logout', function(){
    Auth::logout();
    return redirect('login')->with('status', 'logout successful');
});

Route::get('admin', [LoginController::class, 'index'])->name('admin');
Route::get('admin/login', [LoginController::class, 'index'])->name('admin/login');
Route::post('admin/log',[LoginController::class, 'adminlogin'])->name('admin/log');

Route::middleware(['auth', 'admin'])->group(function () {
Route::get('admin/dashboard', [LoginController::class, 'admindashboard'])->name('admin/dashboard');
    Route::get('/transactions', [LoginController::class, 'getTransactions']);
    Route::get('/transactions1', [LoginController::class, 'getTransactions1']);
    Route::get('admin/deposits', [\App\Http\Controllers\admin\TransactionController::class, 'alldeposit'])->name('admin/deposits');
    Route::get('admin/alltransfer',[\App\Http\Controllers\admin\TransactionController::class, 'allpaylonytransction'])->name('admin/alltransfer');
    Route::get('admin/allvirtual',[\App\Http\Controllers\admin\TransactionController::class, 'allvirtual'])->name('admin/allvirtual');
    Route::get('admin/payvirtual',[\App\Http\Controllers\admin\TransactionController::class, 'allvirtualpaylony'])->name('admin/payvirtual');
    Route::post('admin/date', [\App\Http\Controllers\admin\TransactionController::class, 'querydeposi'])->name('admin/date');
    Route::get('admin/depositquery', [\App\Http\Controllers\admin\TransactionController::class, 'queryindex'])->name('admin/depositquery');

    Route::post('admin/datebill', [\App\Http\Controllers\admin\TransactionController::class, 'querybilldate'])->name('admin/datebill');
    Route::get('admin/billquery', [\App\Http\Controllers\admin\TransactionController::class, 'billdate'])->name('admin/billquery');

    Route::any('admin/report_yearly', [ReportController::class, 'yearly'])->name('report_yearly');
    Route::any('admin/report_monthly', [ReportController::class, 'monthly'])->name('report_monthly');
    Route::any('admin/report_daily', [ReportController::class, 'daily'])->name('report_daily');
    Route::get('admin/allbills', [\App\Http\Controllers\admin\TransactionController::class, 'allpurchase'])->name('admin/allbills');
    Route::get('admin/alluser', [\App\Http\Controllers\admin\UsersController::class, 'index'])->name('admin/alluser');
    Route::get('admin/finds', [UsersController::class, 'fin'])->name('admin/finds');
    Route::get('admin/profile/{username}', [UsersController::class, 'profile'])->name('admin/profile');


    Route::post('admin/cr', [CandCController::class, 'credit'])->name('admin/cr');
    Route::post('admin/ref', [CandCController::class, 'refund'])->name('admin/ref');
    Route::post('admin/bonus', [CandCController::class, 'fundbonus'])->name('admin/bonus');
    Route::post('admin/ch', [CandCController::class, 'charge'])->name('admin/ch');




});
