<?php

namespace App\Business\services;

use App\Business\Entities\Taxes;

class ProductService
{
    public function calculateIVA($price){
        return $price * (1 + Taxes::Iva);
    }
}