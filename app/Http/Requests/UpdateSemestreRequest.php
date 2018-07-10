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

    public function all()
    {
        $input = parent::all();
        $input['inicio'] = date("Y-m-d", strtotime(str_replace('/', '-', $input['inicio'])));
        $input['fim'] = date("Y-m-d", strtotime(str_replace('/', '-', $input['fim'])));

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
            'rotulo' => 'required', 
            'inicio' => 'required|date|interjacente_inicio',
            'fim' => 'required|date|after:inicio|interjacente_fim',
        ];
    }

    public function messages()
    {
        return [
            'rotulo.required' => 'O campo :attribute é obrigatório',
            'inicio.required' => 'O campo :attribute é obrigatório',
            'inicio.date' => 'O campo :attribute não está no formato correto',
            'inicio.interjacente_inicio' => 'O campo :attribute já está registrado em um semestre cadastrado',
            'fim.required' => 'O campo :attribute é obrigatório',
            'fim.date' => 'O campo :attribute não está no formato correto',
            'fim.after' => 'A data de inicio deve começar antes da data final do semestre.',
            'fim.interjacente_fim' => 'O campo :attribute já está registrado em um semestre cadastrado',
        ];
    }
}
