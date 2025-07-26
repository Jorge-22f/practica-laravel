<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\contracts\Validation\Validator;
use Illuminate\Http\Exceptions\HttpResponseException;
use Symfony\Component\HttpFoundation\Response;    
    
Class ApiFormrequest extends FormRequest{
    
    protected function failedValidation(Validator $validator){
        throw new HttpResponseException(response()->json([
            "message" => "Error de validacion",
            "errors" => $validator->errors()

        ], Response::HTTP_UNPROCESSABLE_ENTITY));
    }
}