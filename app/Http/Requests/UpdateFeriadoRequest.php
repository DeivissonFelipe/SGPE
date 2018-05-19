<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateFeriadoRequest extends FormRequest
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


    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'data' => 'required|date|pertence:semestre_id',
            'semestre_id' => 'required| exists:semestres,id',
        ];
    }

    public function messages()
    {
        return [
            'data.required' => 'O campo :attribute é obrigatório',
            'data.date' => 'O campo :attribute não está no formato correto.',
            'data.pertence' => 'O campo :attribute não pertence ao semestre selecionado.',
            'semestre_id.required' => 'O campo semestre não foi selecionado corretamente.',
            'semestre_id.exists' => 'Semestre inexistente.',
            
        ];
    }
}
