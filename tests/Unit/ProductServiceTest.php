<?php

use App\Business\Entities\Taxes;
use App\Business\services\ProductService;

test('Calcula el impuesto iva', function () {
    $price = 100;

    $service = new ProductService();

    $result = $service->calculateIVA($price);

    expect($result)->toBe($price * (1 + Taxes::Iva));
});
