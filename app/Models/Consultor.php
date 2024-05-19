<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Consultor extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = ['nome', 'valor_hora'];

    protected $table = 'consultores';


    /**
     * Retorna se o Consultor está vínculado a um compromisso.
     *
     * @return bool
     */
    public function hasCompromisso(): bool
    {
        return Compromisso::select('id')->where('id_consultor', $this->id)->exists();
    }

    /**
     * Retorna Consultores, mas apenas o ID e o nome deles.
     *
     * @return Collection
     */
    public static function allOnlyIDAndName(): Collection
    {
        return Consultor::all(['id', 'nome']);
    }
}
