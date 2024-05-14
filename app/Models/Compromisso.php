<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Compromisso extends Model
{
    use HasFactory;

    protected $fillable = ['id_consultor', 'data', 'hora_inicio', 'hora_fim', 'intervalo'];
}
