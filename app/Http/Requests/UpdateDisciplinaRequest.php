<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateDisciplinaRequest extends FormRequest
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
            'codigo' => 'required|max:255',
            'nome' => 'required|max:255',
            'name' => 'required|max:255',
            'chsemestral'=>'required|numeric',
            'chsemanalt'=>'required|numeric',
            'chsemanalp'=>'required|numeric|qtdAula:chsemestral,chsemanalt',
            'departamento_id' => 'required|exists:departamentos,id',
        ];
    }

    public function messages()
    {
        return [
            'codigo.required' => 'O campo :attribute é obrigatório.',
            'codigo.max' => 'O campo :attribute atingiu o limite de caracteres.',
            'nome.required' => 'O campo :attribute é obrigatório.',
            'nome.max' => 'O campo :attribute atingiu o limite de caracteres.',
            'name.required' => 'O campo :attribute é obrigatório.',
            'name.max' => 'O campo :attribute atingiu o limite de caracteres.',

            'chsemestral.required'=> 'O campo :attribute é obrigatório.',
            'chsemestral.numeric'=> 'O campo :attribute não é do tipo numérico.',
            
            'chsemanalt.required'=> 'O campo :attribute é obrigatório.',
            'chsemanalt.numeric'=> 'O campo :attribute não é do tipo numérico.',

            'chsemanalp.required'=> 'O campo :attribute é obrigatório.',
            'chsemanalp.numeric'=> 'O campo :attribute não é do tipo numérico.',
            'chsemanalp.qtd_aula'=> 'A quantidade de aulas semanais se encontra inválida.',

            'departamento_id.required' => 'O departamento não foi selecionado corretamente',
            'departamento_id.exists' => 'Departamento inexistente.',
        ];
    }
}

