<?php

namespace App\Http\Requests;

class UpdateProductRequest extends ApiFormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true; // para que entre al metodo
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            "name" => "required|string|max:100",
            "description" => "required|max:1000", //se puede usar nullable cuando no se requiera algo
            "price" => "required|numeric",
            "category_id" => "required|exists:category,id"
        ];
    }

    public function messages()
    {
        return [ // mensajes personalizados opcionales
            "name.required" => "El nombre es obligatorio",
        ];
    }

}

                