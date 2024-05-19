<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

/**
 *  Cuida da validação da FormRequest de um Consultor.
 *  Pode ser reutilizada nas actions create e update.
 */
class ConsultorRequest extends FormRequest
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
        $id_consultor = $this->route('consultore');

        return [
            'nome' => [
                'required',
                'string',
                'max:255',
                Rule::unique('consultores')->ignore($id_consultor)->withoutTrashed(),
            ],
            'valor_hora' => 'required|integer|min:0'
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
            'nome.required' => 'Informe o nome.',
            'nome.string' => 'Informe um nome válido.',
            'nome.max' => 'Informe um nome até 255 caracteres.',
            'nome.unique' => 'Nome existente.',
            'valor_hora.required' => 'Informe o valor por hora.',
            'valor_hora.min' => 'Informe um valor válido.',
            'valor_hora.integer' => 'Informe um valor válido.'
        ];
    }
}
