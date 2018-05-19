<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class AtendimentoRequest extends FormRequest
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
            'inicio' => 'required',
            'fim' => 'required',
            'sala' => 'required|max:255',
            'plano_id' => 'required|exists:planos,id',
        ];
    }

    public function messages()
    {
        return [
            'dia.required' => 'O campo :attribute é obrigatório.',
            'dia.in' => 'Campo :attribute com valor inválido.',
            'inicio.required' => 'O campo :attribute é um campo obrigatório',
            'fim.required' => 'O campo :attribute é um campo obrigatório',
            'sala.required' => 'O campo :attribute é um campo obrigatório',
            'sala.max' => 'O campo :attribute atingiu o limite de caracteres',
            'plano_id.required' => 'O plano de ensino não foi selecionado.',
            'plano_id.exists' => 'Plano de ensino inexistente.',
        ];
    }

    protected function getRedirectUrl()
    {
        $url = $this->redirector->getUrlGenerator();
        return $url->previous() . '#atendimento';
    }
}
