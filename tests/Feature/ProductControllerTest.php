<?php

test('example', function () {  // prueba sin JWT
    $response = $this->getJson('/api/product?per_page=5&page=0');

    $response->assertStatus(200)
        ->assertJsonCount(5);       // confirma que retorna cinco elementos
    
    $data = $response->json();
    expect(count($data))->toBe(5);  // cuando el json tiene una estructura como objeto
});
