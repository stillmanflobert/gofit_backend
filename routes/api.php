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
Route::get('cetak-struk-aktivasi/{id}', 'App\Http\Controllers\Api\TransaksiAktivasiController@cetakStrukAktivasi');
Route::get('cetak-struk-deposit-uang/{id}', 'App\Http\Controllers\Api\TransaksiDepositUangController@cetakStrukDepositUang');
Route::get('cetak-struk-deposit-kelas/{id}', 'App\Http\Controllers\Api\TransaksiDepositKelasController@cetakStrukDepositKelas');
Route::apiResource('transaksi-aktivasi', 'App\Http\Controllers\Api\TransaksiAktivasiController');
Route::apiResource('transaksi-deposit-uang', 'App\Http\Controllers\Api\TransaksiDepositUangController');
Route::apiResource('transaksi-deposit-kelas', 'App\Http\Controllers\Api\TransaksiDepositKelasController');
Route::post('generate-jadwal-harian', 'App\Http\Controllers\Api\JadwalHarianController@createOneWeekSchdule');
Route::apiResource('jadwal-harian', 'App\Http\Controllers\Api\JadwalHarianController');
Route::apiResource('izin-instruktur', 'App\Http\Controllers\Api\IzinInstrukturController');
Route::put('konfirmasi-izin-instruktur', 'App\Http\Controllers\Api\IzinInstrukturController@update');
Route::get('cek-member-kadaluarsa', 'App\Http\Controllers\Api\MemberController@memberKadaluarsa');
Route::post('deactivated-member', 'App\Http\Controllers\Api\MemberController@deaktivasiMember');
Route::get('kelas-kadaluarsa', 'App\Http\Controllers\Api\DepositPaketKelasController@kelasKadaluarsa');
Route::post('deactivated-kelas', 'App\Http\Controllers\Api\DepositPaketKelasController@deaktivatedKelas');
Route::apiResource('booking-kelas', 'App\Http\Controllers\Api\BookingKelasController');
Route::post('batal-booking', 'App\Http\Controllers\Api\BookingKelasController@cekBatalBooking');
Route::post('reset-instruktur', 'App\Http\Controllers\Api\PresensiInstrukturController@resetPresensi');
Route::get('cetak-presensi-gym/{id}', 'App\Http\Controllers\Api\PresensiMemberGymController@cetakStrukPresensiGym');
Route::get('cetak-presensi-kelas/{id}', 'App\Http\Controllers\Api\PresensiMemberKelasController@cetakStrukPresensiKelas');
Route::apiResource('presensi-member-gym', 'App\Http\Controllers\Api\PresensiMemberGymController');
Route::apiResource('presensi-member-kelas', 'App\Http\Controllers\Api\PresensiMemberKelasController');
Route::apiResource('booking-sesi-gym', 'App\Http\Controllers\Api\BookingSesiGymController');
Route::post('batal-booking-gym', 'App\Http\Controllers\Api\BookingSesiGymController@batalBookingGym');
Route::get('tampil-kelas-hari-ini', 'App\Http\Controllers\Api\JadwalHarianController@tampilKelasHariIni');
Route::post('update-waktu-mulai-kelas/{id}', 'App\Http\Controllers\Api\JadwalHarianController@updateWaktuMulaiKelas');
Route::post('update-waktu-selesai-kelas/{id}', 'App\Http\Controllers\Api\JadwalHarianController@updateWaktuSelesaiKelas');
