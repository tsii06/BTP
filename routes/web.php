<?php

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
    return view('auth.client');
})->name('login');

Route::get('/auth', function () {
    return view('auth.login');
})->name('auth');

Route::get('/client/login', function () {
    return view('auth.client');
})->name('client.login');

Route::get('logout', [\App\Http\Controllers\AuthController::class, 'logout'])->name('logout');

Route::get('/import', function () {
    return view('import.import');
})->middleware('admin');
Route::get('/import/paiment', function () {
    return view('import.import2');
})->middleware('admin');


Route::get('/auth/inscription',function (){
    return view('auth.register');
});

Route::get('/trun',[\App\Http\Controllers\AdminController::class,'trun'])->name('trun');

Route::prefix('auth')->name('auth.')->group(function (){
    Route::post('login',[\App\Http\Controllers\AuthController::class,'login'])->name('login');
    Route::post('inscription',[\App\Http\Controllers\AuthController::class,'inscription'])->name('inscription');
    Route::post('clientlog',[\App\Http\Controllers\AuthController::class,'clientlog'])->name('clientlog');
});

Route::prefix('import')->name('import.')->middleware('admin')->group(function (){
    Route::post('csv',[\App\Http\Controllers\ImportController::class,'csv'])->name('csv');
    Route::post('paiment',[\App\Http\Controllers\ImportController::class,'paiment'])->name('paiment');
});

Route::prefix('admin')->name('admin.')->middleware('admin')->group(function (){
    Route::get('dashboard',[\App\Http\Controllers\AdminController::class,'dashboard'])->name('dashboard');
    Route::get('listedevis',[\App\Http\Controllers\AdminController::class,'listedevis'])->name('listedevis');
    Route::get('details/{id}',[\App\Http\Controllers\AdminController::class,'details'])->name('details');
    Route::get('/histogram/{year}',[\App\Http\Controllers\AdminController::class,'showHistogram'])->name('histogram');

});

Route::prefix('client')->name('client.')->group(function (){
    Route::get('demand',[\App\Http\Controllers\client\DemandController::class,'demand'])->name('demand');
    Route::get('liste',[\App\Http\Controllers\client\DemandController::class,'liste'])->name('liste');
    Route::post('insert',[\App\Http\Controllers\client\DemandController::class,'insert'])->name('insert');
    Route::get('export/{id}',[\App\Http\Controllers\client\DemandController::class,'export'])->name('export');
    Route::get('paiment/{id}',[\App\Http\Controllers\client\DemandController::class,'paiment'])->name('paiment');
    Route::post('insertpaiment',[\App\Http\Controllers\client\DemandController::class,'insertpaiment'])->name('insertpaiment');
});

Route::prefix('travaux')->name('travaux.')->middleware('admin')->group(function (){
    Route::get('ressource',[\App\Http\Controllers\TravauxController::class,'insert'])->name('ressource');
    Route::post('modifier',[\App\Http\Controllers\TravauxController::class,'modifier'])->name('modifier');
    Route::get('delete/{id}', [\App\Http\Controllers\TravauxController::class, 'destroy'])->name('destroy');
});

Route::prefix('finition')->name('finition.')->middleware('admin')->group(function (){
    Route::get('ressource',[\App\Http\Controllers\FinitionController::class,'insert'])->name('ressource');
    Route::post('modifier',[\App\Http\Controllers\FinitionController::class,'modifier'])->name('modifier');
    Route::get('delete/{id}', [\App\Http\Controllers\FinitionController::class, 'destroy'])->name('destroy');
});



