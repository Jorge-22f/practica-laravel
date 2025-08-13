<?php

use App\Models\Category;
use App\Models\Product;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Http\Response;
use Tymon\JWTAuth\Facades\JWTAuth;

uses(RefreshDatabase::class); // borra y ejecuta migraciones con cada test

beforeEach(function(){ // Salta la comprobacion del middleware para las pruebas
    //$this->withoutMiddleware("jwt.auth"); // normalmente se usa esta
    $this->withoutMiddleware(\Tymon\JWTAuth\Http\Middleware\Authenticate::class); // no falla
});

// test('Paginado', function () {  // prueba sin JWT
//     $response = $this->getJson('/api/product?per_page=5&page=0');

//     $response->assertStatus(200)
//         ->assertJsonCount(5);       // confirma que retorna cinco elementos

//     $data = $response->json();
//     expect(count($data))->toBe(5);  // cuando el json tiene una estructura como objeto
// });

test('Paginado', function () {  // con JWT
    $user = User::factory()->create();

    $token = JWTAuth::fromUser($user);

    Product::factory()->count(15)->create();  // ejecurtar factories

    $response = $this->withHeader("Autorization", "Bearer $token")
        ->getJson('/api/product?per_page=5&page=0');

    $response->assertStatus(Response::HTTP_OK)
        ->assertJsonCount(5)
        ->assertJsonStructure([
            '*' => ['id', 'name', 'price', 'description', 'category_id']
        ]);

    $data = $response->json();
    expect(count($data))->toBe(5);  // cuando el json tiene una estructura como objeto
});

test('Crear producto de manera correcta', function () {
    $category = Category::factory()->create();

    $productData = [
        'name' => 'Producto A',
        'price' => 99.99,
        'description' => 'Descripción de A',
        'category_id' => $category->id,
    ];

    $response = $this->postJson(route("product.store"), $productData);

    $response->assertStatus(Response::HTTP_OK)
        //->assertJsonStructure(['id','name', 'price', 'description','category_id']); //valida la estructura nombres      
        ->assertJson($productData); //valida los valores retornados exactos estructura y data

    $this->assertDatabaseHas('product', $productData); // valida que la infrmacion exista en la base de datos
});

test('Datos producto de manera erronea', function () {
    $invalidProductData = [
        'name' => '',
        'price' => 'texto',
        'description' => str_repeat("A", 3000),
        'category_id' => 99985
    ];

    $response = $this->postJson(route("product.store"), $invalidProductData);
    //  dd($response->json());
    $response->assertStatus(Response::HTTP_UNPROCESSABLE_ENTITY)
        ->assertJsonValidationErrors(['name', 'price', 'description', 'category_id']);
});

test('Actualizar un producto correctamente', function () {
    $category = Category::factory()->create();
    $product = Product::factory()->create([
        "category_id" => $category->id // toma la categoria recien creada
    ]);

    $newCategory = Category::factory()->create();

    $data = [
        'name' => 'Producto actualizado',
        'price' => 199.99,
        'description' => 'Una descripción',
        'category_id' => $newCategory->id
    ];

    $response = $this->putJson(route("product.update", $product), $data);

    $response->assertStatus(Response::HTTP_OK)
        //->assertJsonFragment([valida las propiedades id, name...])
        ->assertJson([
                'message' => 'Producto actualizado exitosamente',
                'product' => [
                    'id' => $product->id,
                    'name' => 'Producto actualizado',
                    'price' => 199.99,
                    'description' => 'Una descripción',
                    'category_id' => $newCategory->id
                ]
            ]);

    $this->assertDatabaseHas("product", [
        'id' => $product->id,
        'name' => 'Producto actualizado',
        'price' => 199.99,
        'description' => 'Una descripción',
        'category_id' => $newCategory->id
    ]);

});

test('Falla si no se envía category_id', function () {
    $category = Category::factory()->create();
    $product = Product::factory()->create(['category_id' => $category->id]);

    $data = [
        'name' => 'Producto sin categoría',
        'price' => 150.50,
        'description' => 'Una descripción',
    ];

    $response = $this->putJson(route("product.update", $product), $data);

    $response->assertStatus(Response::HTTP_UNPROCESSABLE_ENTITY)
        ->assertJsonValidationErrors(['category_id']);

});

test('Falla si category_id no existe en la base de datos', function () {
    $category = Category::factory()->create();
    $product = Product::factory()->create(['category_id' => $category->id]);

    $data = [
        'name' => 'Producto con categoría inválida',
        'price' => 175.75,
        'category_id' => 99999
    ];

    $response = $this->putJson(route('product.update', $product), $data);

    $response->assertStatus(Response::HTTP_UNPROCESSABLE_ENTITY)
        ->assertJsonValidationErrors(['category_id']);
});

test('Elimina un producto correctamente', function () {
    $product = Product::factory()->create();

    $response = $this->deleteJson(route("product.destroy", $product));

    $response->assertStatus(Response::HTTP_OK)
        ->assertJson(['message' => 'Producto eliminado']);

    // $this->assertDatabaseMissing("product", ["id" => $product->id]); // cuando no es borrrado logico
    $this->assertSoftDeleted("product", ["id" => $product->id]);
});

test('Falla al intentar eliminar un producto que no existe', function () {
    $response = $this->deleteJson(route('product.destroy', ["product" => 987878]));

    $response->assertStatus(Response::HTTP_NOT_FOUND);
});
