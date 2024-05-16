<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Compromisso extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = ['id_consultor', 'data', 'hora_inicio', 'hora_fim', 'intervalo'];
}
