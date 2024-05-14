<?php

use App\Http\Controllers\CompromissoController;
use App\Http\Controllers\ConsultorController;
use Illuminate\Support\Facades\Route;

Route::resource('consultores', ConsultorController::class);

Route::resource('compromissos', CompromissoController::class);
