<?php

use App\Http\Controllers\api\AlltvController;
use App\Http\Controllers\api\EkectController;
use App\Http\Controllers\api\ResellerdetailsController;
use App\Http\Controllers\Api\VerifyController;
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
Route::post('listdata', [\App\Http\Controllers\api\DatacardController::class, 'list'])->name('listdata');
Route::post('listtv', [\App\Http\Controllers\api\DatacardController::class, 'listtv'])->name('listtv');
Route::group(['middleware'=> 'apikey'], function () {
    Route::post('reseller', [\App\Http\Controllers\api\WehookController::class, 'sendwebhook1'])->name('reseller');
    Route::get('dashboard', [ResellerdetailsController::class, 'details']);
    Route::post('createaccount', [\App\Http\Controllers\api\GenerateAccountController::class, 'generateaccount'])->name('createaccount');
    Route::post('createaccount1', [\App\Http\Controllers\api\GenerateAccountController::class, 'generateaccountmcd'])->name('createaccount1');
Route::get('allvirtual', [\App\Http\Controllers\api\FetchVirtualAccountController::class, 'getallmyaccount'])->name('allvirtual');
Route::post('data', [\App\Http\Controllers\api\BillController::class, 'data'])->name('data');
Route::post('airtime', [\App\Http\Controllers\api\AirController::class, 'airtime'])->name('airtime');
Route::post('verifytv', [\App\Http\Controllers\api\AlltvController::class, 'verifytv'])->name('verifytv');
Route::post('paytv', [\App\Http\Controllers\api\AlltvController::class, 'paytv'])->name('paytv');
Route::post('waec', [\App\Http\Controllers\api\EducationApiController::class, 'Waec'])->name('waec');
Route::post('neco', [\App\Http\Controllers\api\EducationApiController::class, 'Neco'])->name('neco');
Route::post('nabteb', [\App\Http\Controllers\api\EducationApiController::class, 'Nabteb'])->name('nabteb');
Route::post('jamb', [\App\Http\Controllers\api\EducationApiController::class, 'mcdJamb'])->name('jamb');
Route::post('verifyid', [\App\Http\Controllers\api\EducationApiController::class, 'mcdverifyprofile'])->name('verifyid');
Route::get('buydatacard', [\App\Http\Controllers\api\DatacardController::class, 'datacardpurchase'])->name('buydatacard');
Route::post('transfer', [\App\Http\Controllers\api\TransferController::class, 'withdraw'])->name('transfer');
    Route::get('listtv', [AlltvController::class, 'listtv']);
    Route::get('listelect', [EkectController::class, 'listelect']);
    Route::get('elect', [EkectController::class, 'electric']);
    Route::post('velect', [EkectController::class, 'verifyelect']);
    Route::post('payelect', [EkectController::class, 'payelect']);
    Route::post('verifybill', [VerifyController::class, 'verifybill']);
    Route::post('verifydeposit', [VerifyController::class, 'verifyfunding']);


});
