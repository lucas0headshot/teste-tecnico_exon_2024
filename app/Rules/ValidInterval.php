<?php

namespace App\Rules;

use Closure;
use Illuminate\Contracts\Validation\ValidationRule;

class ValidInterval implements ValidationRule
{
    private $hora_inicio;
    private $hora_fim;


    public function __construct(string $hora_inicio, string $hora_fim)
    {
        $this->hora_inicio = $hora_inicio;
        $this->hora_fim = $hora_fim;
    }


    /**
     * Run the validation rule.
     *
     * @param  \Closure(string): \Illuminate\Translation\PotentiallyTranslatedString  $fail
     */
    public function validate(string $attribute, mixed $value, Closure $fail): void
    {
        $hora_inicio = strtotime($this->hora_inicio);
        $hora_fim = strtotime($this->hora_fim);
        $intervalo = strtotime($value) - strtotime('TODAY');

        if (($hora_fim - $hora_inicio) <= $intervalo) {
            $fail('O intervalo não pode ser maior ou igual ao período entre a hora de início e hora de fim.');
        }
    }
}
