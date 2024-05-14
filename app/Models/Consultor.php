<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Consultor extends Model
{
    use HasFactory;

    protected $fillable = ['nome', 'valor_hora'];
}
