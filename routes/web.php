<?php

use App\Http\Controllers\CompromissoController;
use App\Http\Controllers\ConsultorController;
use Illuminate\Support\Facades\Route;

Route::redirect('/', 'compromissos');

Route::resource('consultores', ConsultorController::class)->names([
    'index' => 'consultores.index',
    'create' => 'consultores.create',
    'store' => 'consultores.store',
    'show' => 'consultores.show',
    'edit' => 'consultores.edit',
    'update' => 'consultores.update',
    'destroy' => 'consultores.destroy'
]);

Route::resource('compromissos', CompromissoController::class)->names([
    'index' => 'compromissos.index',
    'create' => 'compromissos.create',
    'store' => 'compromissos.store',
    'show' => 'compromissos.show',
    'edit' => 'compromissos.edit',
    'update' => 'compromissos.update',
    'destroy' => 'compromissos.destroy'
]);
