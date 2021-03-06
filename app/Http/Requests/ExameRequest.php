<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ExameRequest extends FormRequest
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
            'descricao' => 'required|max:255',
            'peso' => 'numeric|max:100',
            'data' => 'date|pertence_plano:plano_id|dia_semana|not_exists:feriados,data|campo_unico:exames,data,plano_id|dia_n_lecionado:plano_id,data',
            'conteudo' => 'required',
            'plano_id' => 'required|exists:planos,id',
        ];
    }

    public function messages()
    {
        return [
            'descricao.required' => 'O campo :attribute é obrigatório.',
            'descricao.max' => 'O campo :attribute atingiu o limite de caracteres.',
            'peso.numeric' => 'O campo :attribute deve ser um tipo númerico',
            'peso.max' => 'O campo :attribute não deve ser maior do que 100pts',
            'data.date' => 'O campo :attribute não está no formato correto.',
            'data.pertence_plano' => 'O campo :attribute não pertence ao semestre selecionado.',
            'data.dia_semana' => 'O campo :attribute selecionado não é um dia de semana.',
            'data.not_exists' => 'O campo :attribute selecionado é um feriado e/ou dia não letivo.',
            'data.campo_unico' => 'O campo :attribute selecionado já se encontra registrado na tabela de exames.',
            'data.dia_n_lecionado' => 'O campo :attribute selecionado não pertence aos dias em que esta turma possui aulas. Por favor, selecione outro dia ou acrescente o dia da semana nas configurações do plano.',
            'conteudo.required' => 'O campo :attribute é obrigatório',
            'plano_id.required' => 'O plano de ensino não foi selecionado.',
            'plano_id.exists' => 'Plano de ensino inexistente.',
        ];
    }

}
