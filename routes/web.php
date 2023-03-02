<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\SiswaController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
    return view('welcome');
});

// Route::controller(SiswaController::class)->group(function(){
//     Route::get('siswa', 'index');
//     Route::post('siswa', 'store')->name('image.store');
// });

Route::get('siswaAjax', [SiswaController::class, 'ajax']);

Route::get('siswa', [SiswaController::class, 'index'])->name('siswa.index');
Route::post('siswa', [SiswaController::class, 'store'])->name('image.store');
