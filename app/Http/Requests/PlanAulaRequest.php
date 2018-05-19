<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class PlanAulaRequest extends FormRequest
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

    public function all()
    {
        $input = parent::all();
        $input['data'] = date("Y-m-d", strtotime(str_replace('/', '-', $input['data'])));
        
        return $input;
    }

    public function getSemestre(){
        $input = parent::all();
        $semestre_id = \App\Plano::find($input['plano_id'])->turma()->first()->semestre_id;
        return  $semestre_id;
    }


    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'aula' => 'required|max:255',
            'tipo' => 'required',
            'data' => 'required|date|pertence_plano:plano_id|dia_semana|not_exists:feriados,data',
            'conteudo' => 'required',
            'plano_id' => 'required|exists:planos,id',
        ];
    }

    public function messages()
    {
        return [
            'aula.required' => 'O campo :attribute é obrigatório',
            'aula.max' => 'O campo :attribute atingiu o limite de caracteres',
            'tipo.required' => 'O campo :attribute é obrigatório',
            'data.required' => 'O campo :attribute é obrigatório',
            'data.date' => 'O campo :attribute não está no formato correto.',
            'data.pertence_plano' => 'O campo :attribute não pertence ao semestre selecionado.',
            'data.dia_semana' => 'O campo :attribute selecionado não é um dia de semana.',
            'data.not_exists' => 'O campo :attribute selecionado é um feriado e/ou dia não letivo.',
            'conteudo.required' => 'O campo :attribute é obrigatório',
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
