<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateTrocaRequest extends FormRequest
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
        $input['dia'] = date("Y-m-d", strtotime(str_replace('/', '-', $input['dia'])));
        
        return $input;
    }


    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'dia' => 'required|date|pertence:semestre_id|dia_semana|not_exists:feriados,data',
            'substituicao' => 'required',
            'semestre_id' => 'required| exists:semestres,id',
        ];
    }

    public function messages()
    {
        return [
            'dia.required' => 'O campo :attribute é obrigatório',
            'dia.date' => 'O campo :attribute não está no formato correto.',
            'dia.pertence' => 'O campo :attribute não pertence ao semestre selecionado.',
            'dia.dia_semana' => 'O dia selecionado não é um dia de semana.',
            'dia.not_exists' => 'O dia selecionado é um feriado e/ou dia não letivo.',
            'substituicao.required' => 'O campo :attribute é obrigatório.',
            'semestre_id.required' => 'O campo semestre não foi selecionado corretamente.',
            'semestre_id.exists' => 'Semestre inexistente.',
        ];
    }
}
