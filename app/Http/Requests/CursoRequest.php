<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class CursoRequest extends FormRequest
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
            'nome' => 'required|max:255',
            'sigla' => 'required|max:255|unique:cursos',
        ];
    }
    
    public function messages()
    {
        return [
            'nome.required' => 'O campo :attribute é obrigatório.',
            'nome.max' => 'O campo :attribute atingiu o limite de caracteres',
            'sigla.required' => 'O campo :attribute é obrigatório.',
            'sigla.max' => 'O campo :attribute atingiu o limite de caracteres',
            'sigla.unique' => 'Já existe um registro no banco de dados com este campo :attribute',
        ];
    }
}
