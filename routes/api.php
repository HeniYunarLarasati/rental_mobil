<?php

use Illuminate\Http\Request;

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

Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});
Route::post('register', 'PetugasController@register');
Route::post('login', 'PetugasController@login');
Route::get('/',function(){
  return Auth::user()->level;
})->middleware('jwt.verify');
Route::get('petugas','PetugasController@tampil')->middleware('jwt.verify');
Route::put('petugas/{id}', 'PetugasController@update')->middleware('jwt.verify');
Route::delete('petugas/{id}','PetugasController@delete')->middleware('jwt.verify');

Route::post('penyewa','PenyewaController@store')->middleware('jwt.verify');
Route::get('penyewa','PenyewaController@tampil')->middleware('jwt.verify');
Route::put('penyewa/{id}', 'PenyewaController@update')->middleware('jwt.verify');
Route::delete('penyewa/{id}','PenyewaController@delete')->middleware('jwt.verify');

Route::post('mobil','MobilController@store')->middleware('jwt.verify');
Route::get('mobil','MobilController@tampil')->middleware('jwt.verify');
Route::put('mobil/{id}', 'MobilController@update')->middleware('jwt.verify');
Route::delete('mobil/{id}','MobilController@delete')->middleware('jwt.verify');

Route::post('jenis','jenisController@store')->middleware('jwt.verify');
Route::get('jenis','jenisController@tampil')->middleware('jwt.verify');
Route::put('jenis/{id}', 'jenisController@update')->middleware('jwt.verify');
Route::delete('jenis/{id}','jenisController@delete')->middleware('jwt.verify');

Route::post('transaksi','TransaksiController@store')->middleware('jwt.verify');
Route::get('transaksi','TransaksiController@tampil')->middleware('jwt.verify');
Route::put('transaksi/{id}', 'TransaksiController@update')->middleware('jwt.verify');
Route::delete('transaksi/{id}','TransaksiController@delete')->middleware('jwt.verify');

Route::post('detail','DetailTransController@store')->middleware('jwt.verify');
Route::get('detail/{tgl_transaksi}/{tgl_jadi}','DetailTransController@tampil')->middleware('jwt.verify');
Route::put('detail/{id}', 'DetailTransController@update')->middleware('jwt.verify');
Route::delete('detail/{id}','DetailTransController@delete')->middleware('jwt.verify');
