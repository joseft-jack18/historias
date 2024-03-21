<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\PersonsController;
use App\Http\Controllers\MedicalRecordsController;
use App\Http\Controllers\SearchController;
use App\Http\Controllers\HomeController;
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




Auth::routes();

Route::middleware('auth')->group(function () {

    Route::get('/', [HomeController::class, 'index'])->name('home');

    Route::get('/', [PersonsController::class, 'index'])->name('persons.index');
    Route::get('/person/create_person', [PersonsController::class, 'create'])->name('persons.create');
    Route::post('/person/store_person', [PersonsController::class, 'store'])->name('persons.store');
    Route::get('/person/edit_person/{id}', [PersonsController::class, 'edit'])->name('persons.edit');
    Route::put('/person/update_person/{id}', [PersonsController::class, 'update'])->name('persons.update');


    Route::get('/history/{id}', [MedicalRecordsController::class, 'index'])->name('history.index');
    Route::get('/history/create/{id}', [MedicalRecordsController::class, 'create'])->name('history.create');
    Route::post('/history/store', [MedicalRecordsController::class, 'store'])->name('history.store');

    Route::get('/history/pdf/{id}', [MedicalRecordsController::class, 'pdf_history'])->name('history.pdf_history');
    Route::get('/history/pdf_procedure/{id}', [MedicalRecordsController::class, 'pdf_procedures'])->name('history.pdf_procedure');
    Route::get('/history/pdf_medical/{id}', [MedicalRecordsController::class, 'pdf_medical'])->name('history.pdf_medical');


    Route::get('/search/autocomplete_d', [SearchController::class, 'autocomplete_diagnosticos'])->name('search.autocomplete_diagnosticos');
    Route::get('/search/autocomplete_i', [SearchController::class, 'autocomplete_interconsultas'])->name('search.autocomplete_interconsultas');
    Route::get('/search/autocomplete_l', [SearchController::class, 'autocomplete_laboratorios'])->name('search.autocomplete_laboratorios');
    Route::get('/search/autocomplete_r', [SearchController::class, 'autocomplete_radiologicos'])->name('search.autocomplete_radiologicos');
    Route::get('/search/autocomplete_m', [SearchController::class, 'autocomplete_medicamentos'])->name('search.autocomplete_medicamentos');

});
