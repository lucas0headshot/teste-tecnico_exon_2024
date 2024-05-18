<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

/**
 *  Cuida da validação da FormRequest de um Compromisso.
 *  Pode ser reutilizada nas actions create e update.
 */
class CompromissoRequest extends FormRequest
{
    /**
     * Determina se a request está autorizada.
     *
     * @return bool
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Retorna as regras de validação;
     *
     * @return array
     */
    public function rules(): array
    {
        return [
            'id_consultor' => [
                'required',
                'integer',
                Rule::exists('consultores', 'id'),
            ],
            'data' => 'required|date|after:now|date_format:Y-m-d',
            'hora_inicio' => 'required|date_format:H:i',
            'hora_fim' => 'required|after:hora_inicio|date_format:H:i',
            'intervalo' => 'required|date_format:H:i',
        ];
    }

    /**
     * Retorna as mensagens de validação.
     *
     * @return array
     */
    public function messages(): array
    {
        return [
            'id_consultor.required' => 'Informe o consultor.',
            'id_consultor.integer' => 'Informe um consultor válido.',
            'data.required' => 'Informe a data.',
            'data.date' => 'Informe uma data válida.',
            'data.after' => 'A data deve ser no futuro.',
            'data.date_format' => 'Informe uma data válida.',
            'hora_inicio.required' => 'Informe a hora de início.',
            'hora_inicio.date_format' => 'Informe uma hora de início válida.',
            'hora_fim.required' => 'Informe a hora de fim.',
            'hora_fim.after' => 'A hora de fim deve ser após a hora de início.',
            'hora_fim.date_format' => 'Informe uma hora de fim válida.',
            'intervalo.required' => 'Informe o intervalo.',
            'intervalo.date_format' => 'Informe um intervalo válido.',
        ];
    }
}
