<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\PersonsController;
use App\Http\Controllers\MedicalRecordsController;

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

/*Route::get('/', function () {
    return view('welcome');
});*/

Route::get('/', [PersonsController::class, 'index'])->name('persons.index');
Route::get('/create_person', [PersonsController::class, 'create'])->name('persons.create');
Route::post('/store_person', [PersonsController::class, 'store'])->name('persons.store');
Route::get('/edit_person/{id}', [PersonsController::class, 'edit'])->name('persons.edit');
Route::put('/update_person/{id}', [PersonsController::class, 'update'])->name('persons.update');

Route::get('/history/{id}', [MedicalRecordsController::class, 'index'])->name('history.index');
Route::get('/history/create/{id}', [MedicalRecordsController::class, 'create'])->name('history.create');
