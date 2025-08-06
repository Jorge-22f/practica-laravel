<?php

namespace App\ExternalService;

use Illuminate\Support\Facades\Http;

class ApiService
{
    protected string $url;

    public function __construct(string $url){
        $this->url = $url;
    }

    public function getData(){
        $response = Http::get($this->url); // para no verificar certificado Http::withoutVerifying()->get

        if($response->successful()){
            return $response->json();
        }

        return ['error' => 'Ocurrio un error al obtener la informacion'];
    }
}