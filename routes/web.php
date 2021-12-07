<?php

use App\Http\Controllers\ScheduleSettingsController;
use App\Models\Schedule_settings;
use Illuminate\Support\Facades\Route;

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

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth'])->name('dashboard');

Route::get('/configuracoes', function () {
    
})->middleware(['auth'])->name('configuracoes');

//Rotas de Configurações
Route::get('/configuracoes', [ScheduleSettingsController::class, 'create'])->middleware('auth')->name('configuracoes');

Route::post('/configuracoes', [ScheduleSettingsController::class, 'store'])->middleware('auth')->name('configuracoes');                

require __DIR__.'/auth.php';
