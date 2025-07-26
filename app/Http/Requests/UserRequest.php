<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UserRequest extends ApiFormRequest
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
            'name' => 'required|string|max:100',
            'email' => 'required|string|email|max:250|unique:users',
            'password' => 'required|string|min:8',
        ];
    }

        public function messages()
    {
        return [
            'name.required' => 'El nombre del usuario es obligatorio',
            'name.string' => 'El nombre debe ser una cadena de texto',
            'name.max' => 'El nombre puede superar los 100 caracteres',
            'email.required' => 'El correo electronico es obligatorio',
            'email.string' => 'El correo debe ser una cadena de texto',
            'email.email' => 'El correo debe ser un correo valido',
            'email.max' => 'El correo no debe superar los 250 caracteres',
            'email.unique' => 'El correo ya esta en uso',
            'password.required' => 'La contraseña es obligatorio',
            'password.string' => 'La contraseña debe ser una cadena de texto',
            'password.min' => 'La contraseña debe tener al menos 6 caracteres',
        ];
    }
}
