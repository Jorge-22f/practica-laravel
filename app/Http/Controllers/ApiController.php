<?php

namespace App\Http\Controllers;

use App\ExternalService\ApiService;
use Illuminate\Http\Request;

class ApiController extends Controller
{
    protected ApiService $apiService;

    public function __construct(ApiService $apiService){
        $this->apiService = $apiService;
    }

    public function get(){
        $data = $this->apiService->getData();
        return response()->json($data);
    }
}
