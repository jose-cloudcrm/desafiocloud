<?php

namespace App\Http\Requests;

use Illuminate\Contracts\Validation\Validator;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Exceptions\HttpResponseException;

class UserRequest extends FormRequest
{
    /**
     * Determine se o usuário está autorizado a fazer essa solicitação.
     */
    public function authorize(): bool
    {
        return true;
    }

    protected function failedValidation(Validator $validator)
    {
        throw new HttpResponseException(response()->json([
            'status' => false,
            'errors' =>$validator->errors()
        ], 422));
    }

    /**
     * Obtenha as regras de validação que se aplicam à solicitação.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules() : array
    {
        $userId =  $this->route('user');

        return [
            'name' => 'required',
            'email' => 'required|email|unique:users,email,'. ($userId ? $userId->id : null),
            'password' => 'required|min:6',
            'birthday' => 'required|date',
        ];
    }





    /**
     * Obtenha as regras de validação que se aplicam à solicitação.
     *
     * @return array
     * */
    public function messages() : array
    {
        return [
            'name.required' => 'Campo nome e obrigatorio!',
            'email.required' => 'Campo e-mail é obrigatório!',
            'email.email' => 'Necessario enviar e-mail válido!',
            'email.unique' => 'O e-mail já esta cadastrado!',
            'password.required' => 'Campo senha e obrigatorio!',
            'password.min' => 'Senha com no mínimo :min caracteres!',
            'birthday.required' => 'Campo date e obrigatorio',
        ];
    }
}

