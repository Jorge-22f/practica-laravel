<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Symfony\Component\HttpFoundation\Response;
use illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class BackendController extends Controller
{
    private $names = [
        1 => ["name" => "Ana", "age" => 30],
        2 => ["name" => "Pedro", "age" => 25],
        3 => ["name" => "Alexandra", "age" => 30],
    ];

    public function getAll()
    {
        return response()->json($this->names);
    }

    public function get(int $id = 0)
    {
        if (isset($this->names[$id])) {
            return response()->json($this->names[$id]);
        }

        return response()->json(["error" => "Persona no existe"], Response::HTTP_NOT_FOUND);
    }

    public function create(Request $request)
    {
        // dd($request->all());
        Log::info('Contenido JSON recibido:', $request->all());

        $person = [
            "id" => count($this->names) + 1,
            "name" => $request->input("name"),
            "age" => $request->input("age")
        ];

        $this->names[$person["id"]] = $person;

        return response()->json(["message" => "Persona creada", "person" => $person], Response::HTTP_CREATED);
    }

    public function update(Request $request, int $id)
    {

        Log::info('Contenido JSON recibido:', $request->json()->all());

        if (isset($this->names[$id])) {
            // en caso que solo se envie un dato se acepta un valor default
            $this->names[$id]["name"] = $request->json("name", $this->names[$id]["name"]);
            $this->names[$id]["age"] = $request->json("age");

            return response()->json(['menssage' => 'Persona actualizada', 'person' => $this->names[$id]]);
        }
        return response()->json(["error" => "Persona no existe"], Response::HTTP_NOT_FOUND);
    }

    public function delete(int $id)
    {
        if (isset($this->names[$id])) {

            unset($this->names[$id]);

            return response()->json(['menssage' => 'Persona eliminada']);
        }
        return response()->json(["error" => "Persona no existe"], Response::HTTP_NOT_FOUND);
    }
}
