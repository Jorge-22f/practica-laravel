<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Http\Requests\LoginRequest;
use App\Http\Requests\UserRequest;
use App\Models\User;
use Illuminate\Http\Request;
use PhpParser\Node\Stmt\Return_;
use Symfony\Component\HttpFoundation\Response;
use Tymon\JWTAuth\Exceptions\JWTException;
use Tymon\JWTAuth\Facades\JWTAuth;

class AuthController extends Controller
{
    public function register(UserRequest $request){
        $validateData = $request->validated();

        $user = User::create([
            'name' => $validateData["name"],
            'email' => $validateData["email"],
            'password' => bcrypt($validateData["password"])
        ]);

        return response()->json(["message" => "Usuario registrado correctamente"], Response::HTTP_CREATED);
    }

    public function login(LoginRequest $request){
        $validatedData = $request->validated();

        $credentials = ['email' => $validatedData['email'], 'password' => $validatedData['password']];

        try{
            if(!$token = JWTAuth::attempt($credentials)){
                return response()->json(['error' => 'Usuario o contraseña erronea'], Response::HTTP_UNAUTHORIZED);
            }
        }catch(JWTException){
            return response()->json(['error' => 'No se pudo generar el token'], Response::HTTP_INTERNAL_SERVER_ERROR);
        }

        return $this -> respondWithToken($token);
    }

    protected function respondWithToken($token){
        return response()->json([
            'token' => $token,
            'token_type' => 'bearer',
            'expires_in' => auth()->factory()->getTTL()
        ]);
    }

    public function who(){
        $user = auth()->user();

        return response()->json($user);
    }

    public function logout(){
        try{
            $token = JWTAuth::getToken();
            JWTAuth::invalidate($token);

            return response()->json(['message' => 'Sesion cerrada correctamente']);
        }catch(JWTException $e){
            return response()->json(['error' => 'No se pudo cerrar la sesion, el token no es valido'], Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }

    public function refresh(){
        try {
            $token = JWTAuth::getToken();
            $newtoken = auth()->refresh();
            JWTAuth::invalidate($token);

            return $this->respondWithToken($newtoken);
        } catch (JWTException $e) {
            return response()->json(['error' => 'Error al refrescar el token'], Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }
}
