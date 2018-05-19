<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class TurmaRequest extends FormRequest
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
            'disciplina_id' => 'required|exists:disciplinas,id|nao_ofertada:curso_id', 
            'semestre_id' => 'required|exists:semestres,id',
            'curso_id' => 'required|exists:cursos,id',
        ];
    }

    public function messages()
    {
        return [
            'disciplina_id.required' => 'O campo disciplina não foi selecionado corretamente.',
            'disciplina_id.exists' => 'Disciplina inexistente.',
            'disciplina_id.nao_ofertada' => 'A disciplina selecionada não é ofertada pelo curso escolhido.',
            'semestre_id.required' => 'O campo semestre não foi selecionado corretamente.',
            'semestre_id.exists' => 'Semestre inexistente.',
            'cursos_id.required' => 'O campo curso não foi selecionado corretamente.',
            'cursos_id.exists' => 'Curso inexistente',
        ];
    }
}
