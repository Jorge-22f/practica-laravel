<?php

namespace App\Http\Controllers;

use App\Http\Requests\UpdateProductRequest;
use App\Models\Product;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Validation\ValidationException;
use Symfony\Component\HttpFoundation\Response;

use function Pest\Laravel\json;

class ProductController extends Controller
{
    public function index(Request $request){
        $perPage = $request->query("per_page", 10); // obtenemos la informacion de la ruta con query
        $page = $request->query("page", 0);
        $offset = $page * $perPage;

        $products = Product::skip($offset)->take($perPage)->get(); //skip ignora los registros anteriores

        return response()->json($products);
    }

    public function store(Request $request){
        try {
            $validatedData = $request->validate([
                "name" => "required|string|max:100",
                "description" => "required|max:1000", //se puede usar nullable cuando no se requiera algo
                "price" => "required|numeric",
                "category_id" => "required|exists:category,id"
            ],[ // mensajes personalizados opcionales
                "name.required" => "El nombre es obligatorio",
            ]);

            $product = Product::create($validatedData);

            return response()->json($product);
        } catch (ValidationException $e) {
            return response()->json(["error" => $e -> errors()], Response::HTTP_UNPROCESSABLE_ENTITY);
        }

    }

    public function update(UpdateProductRequest $request, Product $product){
        //dd($product->id); // dump and die ayuda a la depuracion
        try{
            $validatedData = $request->validated();
            $product->update($validatedData);
        
            return response()->json(["message" => "Producto actualizado exitosamente", "product" => $product]);
        }catch(Exception $e){
            return response()->json(["error" => $e], Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }

    public function destroy(Product $product){
        $product->delete();

        return response()->json(["message"=>"producto eliminado"]);
    }

    // eliminacion logica
    
}
