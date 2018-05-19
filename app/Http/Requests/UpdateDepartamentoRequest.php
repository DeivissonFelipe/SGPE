<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateDepartamentoRequest extends FormRequest
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
            'sigla' => 'required||max:255',
        ];
    }


    public function messages()
    {
        return [
            'sigla.required' => 'O campo :attribute é obrigatório.',
            'sigla.max' => 'O campo :attribute atingiu o limite de caracteres.',
        ];
    }
}
