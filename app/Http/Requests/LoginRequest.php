<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class LoginRequest extends ApiFormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'email' => 'required|string|email|max:250',
            'password' => 'required|string|min:8',
        ];
    }

        public function messages()
    {
        return [
            'email.required' => 'El correo electronico es obligatorio',
            'email.string' => 'El correo debe ser una cadena de texto',
            'email.email' => 'El correo debe ser un correo valido',
            'email.max' => 'El correo no debe superar los 250 caracteres',
            'password.required' => 'La contraseña es obligatorio',
            'password.string' => 'La contraseña debe ser una cadena de texto',
            'password.min' => 'La contraseña debe tener al menos 6 caracteres',
        ];
    }
}
