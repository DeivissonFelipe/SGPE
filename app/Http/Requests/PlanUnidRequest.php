<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class PlanUnidRequest extends FormRequest
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
            'unidade' => 'required|integer',
            'hora_aula' => 'required|integer',
            'descricao' => 'required',
            'plano_id' => 'required|exists:planos,id',
        ];
    }

    public function messages()
    {
        return [
            'unidade.required' => 'O campo :attribute é obrigatório',
            'unidade.integer' => 'O campo :attribute deve ser do tipo númerico',
            'hora_aula.required' => 'O campo :attribute é obrigatório',
            'hora_aula.integer' => 'O campo :attribute deve ser do tipo númerico',
            'descricao.required' => 'O campo :attribute é obrigatório',
            'plano_id.required' => 'O plano de ensino não foi selecionado.',
            'plano_id.exists' => 'Plano de ensino inexistente.',
        ];
    }

    protected function getRedirectUrl()
    {
        $url = $this->redirector->getUrlGenerator();
        return $url->previous() . '#planejamento';
    }
}
