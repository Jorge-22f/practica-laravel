<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class UpperCaseName
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        if($request->has("name")){ //has verifica si existe 
            $request->merge([ //merge agrega o reemplaza elementos 
                "name" => strtoupper($request->input("name"))
            ]);
        }

        return $next($request);
    }
}
