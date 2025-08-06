<?php

namespace App\Listeners;

use App\Events\UserRegistered;
use Exception;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Support\Facades\Log;

class LogUserRegistered implements ShouldQueue // implements ShouldQueue hace que el evento se ejecute en segundo plano
{
    use InteractsWithQueue; // para interactuar con un queue asi parar un proceso eliminarlo ponerlo en espera reintentar

    public $tries = 3; // numero de veces que deseo que se intente

    /**
     * Create the event listener.
     */
    public function __construct()
    {
        //
    }

    /**
     * Handle the event.
     */
    public function handle(UserRegistered $event): void // si se requiere escuchar mas eventos se agrega | nombreEvento
    {
        $this->release(5);  // intentar en x segundos
        throw new Exception("Ocurrio un error al registrar usuario: {$this->attempts()}");
        // Log::info("Nuevo usuario registrado", ["id" => $event->user->id]); // registrar un evento
    }

    public function failed(UserRegistered $event, $exception){
        Log::critical("El registro en el log del usuario {$event->user["id"]}");
    }
}
