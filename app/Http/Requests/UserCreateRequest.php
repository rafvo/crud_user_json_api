<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Http\Exceptions\HttpResponseException;
use App\Rules;

class UserCreateRequest extends FormRequest
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
            'name' => [
                'required',
                'string',
                'present'
            ],
            'user_name' => [
                'required',
                'string',
                'present',
                new Rules\ExistUserName()
            ],
            'email' => [
                'required',
                'email',
                'string',
                'present',
                new Rules\ExistEmail()
            ],
            'password' => [
                'required',
                'string',
                'present',
                'min:6'
            ],
        ];
    }

    /**
     * Get the error messages for the defined validation rules.
     *
     * @return array
     */
    public function messages()
    {
        return [
            'name.required' => 'Nome é obrigatório',
            'name.string' => 'Nome deve ser do tipo texto',
            'name.present' => 'Nome deve ser enviado',

            'user_name.required' => 'Nome de Usuário é obrigatório',
            'user_name.string' => 'Nome de Usuário deve ser do tipo texto',
            'user_name.present' => 'Nome de Usuário deve ser enviado',

            'email.required' => 'E-mail é obrigatório',
            'email.email' => 'E-mail inválido',
            'email.string' => 'E-mail deve ser do tipo texto',
            'email.present' => 'E-mail deve ser enviado',

            'password.required' => 'Senha é obrigatório',
            'name.string' => 'Senha deve ser do tipo texto',
            'password.present' => 'Senha deve ser enviada',
            'password.min' => 'Senha deve ter no mínimo 6 caracteres',
        ];
    }

    protected function failedValidation(Validator $validator)
    {
        throw new HttpResponseException(response()->json($validator->errors(), 422));
    }
}
