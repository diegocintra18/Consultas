<?php

use App\Http\Controllers\PatientController;
use App\Http\Controllers\ScheduleController;
use App\Http\Controllers\ScheduleExcludeController;
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
Route::middleware(['auth'])->group(function () {
    Route::get('/configuracoes', [ScheduleSettingsController::class, 'index'])->name('schedule.index');
    Route::get('/cadastro-configuracoes', [ScheduleSettingsController::class, 'create'])->name('schedule.create');
    Route::delete('/excluir-configuracoes/{id}', [ScheduleSettingsController::class, 'destroy'])->name('schedule.destroy');
    Route::get('/configuracoes/{id}', [ScheduleSettingsController::class, 'show'])->name('schedule.show');
    Route::post('/salvar-configuracoes', [ScheduleSettingsController::class, 'store'])->name('schedule.store');
    Route::post('/configuracoes', [ScheduleSettingsController::class, 'update'])->name('schedule.update');

    Route::get('/exclusao', [ScheduleExcludeController::class, 'index'])->name('scheduleexclude.index');
    Route::post('/cadastro-exclusao', [ScheduleExcludeController::class, 'store'])->name('scheduleexclude.store');
    Route::delete('excluir-exclusaoagenda/{id}', [ScheduleExcludeController::class, 'destroy'])->name('scheduleexclude.destroy');
});

//Rotas de Pacientes
Route::middleware(['auth'])->group(function () {
    Route::get('/pacientes', [PatientController::class, 'index'])->name('patients.index');
    Route::get('/cadastrar-paciente', [PatientController::class, 'create'])->name('patients.create');
    Route::post('/cadastrar-paciente', [PatientController::class, 'store'])->name('patients.store');
    Route::get('/editar-paciente/{id}', [PatientController::class, 'show'])->name('patients.show');
    Route::post('/atualizar-paciente', [PatientController::class, 'update'])->name('patients.update');
    Route::delete('/excluir-paciente/{id}', [PatientController::class, 'destroy'])->name('patients.destroy');
});

//Rotas de Consultas
Route::middleware(['auth'])->group(function () {
    Route::get('/consultas', [ScheduleController::class, 'index'])->name('schedules.index');
    Route::get('/agendar-consulta', [ScheduleController::class, 'create'])->name('schedules.create');
    // Route::post('/cadastrar-paciente', [PatientController::class, 'store'])->name('patients.store');
    // Route::get('/editar-paciente/{id}', [PatientController::class, 'show'])->name('patients.show');
    // Route::post('/atualizar-paciente', [PatientController::class, 'update'])->name('patients.update');
    // Route::delete('/excluir-paciente/{id}', [PatientController::class, 'destroy'])->name('patients.destroy');
});  

require __DIR__.'/auth.php';
