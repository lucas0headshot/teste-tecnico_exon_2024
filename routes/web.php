<?php

use App\Http\Controllers\CompromissoController;
use App\Http\Controllers\ConsultorController;
use Illuminate\Support\Facades\Route;

//Rota default
Route::redirect('/', 'compromissos');

//Rotas Consultor
Route::resource('consultores', ConsultorController::class)->parameters(['consultores', 'consultor', 'consultore'])
    ->names([
        'index' => 'consultores.index',
        'create' => 'consultores.create',
        'store' => 'consultores.store',
        'show' => 'consultores.show',
        'edit' => 'consultores.edit',
        'update' => 'consultores.update',
        'destroy' => 'consultores.destroy'
    ]);

//Rotas Compromisso
Route::resource('compromissos', CompromissoController::class)->names([
    'index' => 'compromissos.index',
    'create' => 'compromissos.create',
    'store' => 'compromissos.store',
    'show' => 'compromissos.show',
    'edit' => 'compromissos.edit',
    'update' => 'compromissos.update',
]);
