<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Consultor extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = ['nome', 'valor_hora'];

    protected $table = 'consultores';


    public function hasCompromisso(): bool
    {
        return Compromisso::select('id')->where('id_consultor', $this->id)->exists();
    }
}
