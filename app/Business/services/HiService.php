<?php

namespace App\Business\services;

use App\Business\Interfaces\MessageServiceInterface;

class HiService implements MessageServiceInterface
{
    public function hi(){
        return "Hola mundo";
    }
}