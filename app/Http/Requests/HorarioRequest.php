<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class HorarioRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

     /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'dia' => 'required|in:Segunda-Feira,Terça-Feira,Quarta-Feira,Quinta-Feira,Sexta-Feira',
            'inicio' => 'required|valid_time',
            'fim' => 'required|valid_time',
            'plano_id' => 'required|exists:planos,id',
        ];
    }

    public function messages()
    {
        return [
            'dia.required' => 'O campo :attribute é obrigatório.',
            'dia.in' => 'Campo :attribute com valor inválido.',
            'inicio.required' => 'O campo :attribute é um campo obrigatório',
            'inicio.valid_time' => 'O campo :attribute não está em um formato de hora válido.',
            'fim.required' => 'O campo :attribute é um campo obrigatório',
            'fim.valid_time' => 'O campo :attribute não está em um formato de hora válido',
            'plano_id.required' => 'O plano de ensino não foi selecionado.',
            'plano_id.exists' => 'Plano de ensino inexistente.',
        ];
    }

    protected function getRedirectUrl()
    {
        $url = $this->redirector->getUrlGenerator();
        return $url->previous() . '#aula';
    }
}
