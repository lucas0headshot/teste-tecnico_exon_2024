<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\SoftDeletes;

class Compromisso extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = ['id_consultor', 'data', 'hora_inicio', 'hora_fim', 'intervalo'];


    /**
     * Retorna a relação entre compromisso e consultor
     *
     * @return BelongsTo
     */
    public function consultor(): BelongsTo
    {
        return $this->belongsTo(Consultor::class, 'id_consultor');
    }

    /**
     * Calcula e retorna o total de horas.
     *
     * @return string
     */
    public function calcularTotalHoras(): string
    {
        $hora_inicio = Carbon::createFromFormat('H:i:s', $this->hora_inicio);
        $hora_fim = Carbon::createFromFormat('H:i:s', $this->hora_fim);
        $intervalo = Carbon::createFromFormat('H:i:s', $this->intervalo);

        return $hora_inicio->diffInMinutes($hora_fim) - ($intervalo->hour * 60 + $intervalo->minute);
    }

    /**
     * Calcula e retorna o valor total.
     *
     * @return string
     */
    public function calcularValorTotal(): string
    {
        return ($this->calcularTotalHoras() / 60) * $this->consultor->valor_hora;
    }
}
