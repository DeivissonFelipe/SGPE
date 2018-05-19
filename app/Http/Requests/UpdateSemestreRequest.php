<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateSemestreRequest extends FormRequest
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
            'rotulo' => 'required', 
            'inicio' => 'required|date',
            'fim' => 'required|date|after:inicio',
        ];
    }

    public function messages()
    {
        return [
            'rotulo.required' => 'O campo :attribute é obrigatório',
            'inicio.required' => 'O campo :attribute é obrigatório',
            'inicio.date' => 'O campo :attribute não está no formato correto',
            'fim.required' => 'O campo :attribute é obrigatório',
            'fim.date' => 'O campo :attribute não está no formato correto',
            'fim.after' => 'A data de inicio deve começar antes da data final do semestre.',
        ];
    }
}
