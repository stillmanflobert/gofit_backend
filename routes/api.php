<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

// Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
//     return $request->user();
// });

Route::post('/login', 'App\Http\Controllers\Api\UserController@login');
Route::post('/update-foto', 'App\Http\Controllers\Api\UserController@updateFoto');
Route::get('/get-foto/{id}', 'App\Http\Controllers\Api\UserController@getImage');
Route::get('/getuser/{id}', 'App\Http\Controllers\Api\UserController@getUser');
Route::post('/change-password', 'App\Http\Controllers\Api\UserController@changePassword');
Route::apiResource('kelas', 'App\Http\Controllers\Api\KelasController');
Route::apiResource('promo', 'App\Http\Controllers\Api\PromoController');
Route::apiResource('pegawai', 'App\Http\Controllers\Api\PegawaiController');
Route::apiResource('instruktur', 'App\Http\Controllers\Api\InstrukturController');
Route::apiResource('member', 'App\Http\Controllers\Api\MemberController');
Route::get('cetak-member-card/{id}', 'App\Http\Controllers\Api\MemberController@printMemnberCard');
Route::post('aktivasiMember/{id}', 'App\Http\Controllers\Api\MemberController@aktivasiMember');
Route::post('resetPassword/{id}', 'App\Http\Controllers\Api\MemberController@resetPasswordMember');
Route::apiResource('jadwal-default', 'App\Http\Controllers\Api\JadwalDefaultController');
Route::get('get-jadwal-default', 'App\Http\Controllers\Api\JadwalDefaultController@getJadwalByDay');
