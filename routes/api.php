<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});
Route::post('paylony', [\App\Http\Controllers\api\WehookController::class, 'sendwebhook'])->name('paylony');

Route::group(['middleware'=> 'apikey'], function () {
Route::post('createaccount', [\App\Http\Controllers\api\GenerateAccountController::class, 'generateaccount'])->name('createaccount');
Route::get('allvirtual', [\App\Http\Controllers\api\FetchVirtualAccountController::class, 'getallmyaccount'])->name('allvirtual');
Route::post('data', [\App\Http\Controllers\api\BillController::class, 'data'])->name('data');
Route::post('airtime', [\App\Http\Controllers\api\AirController::class, 'airtime'])->name('airtime');
Route::post('verifytv', [\App\Http\Controllers\api\AlltvController::class, 'verifytv'])->name('verifytv');
Route::post('paytv', [\App\Http\Controllers\api\AlltvController::class, 'paytv'])->name('paytv');


});
