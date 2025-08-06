<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;

class Hi extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:hi {name : Nombre de la persona} 
                             {--lastName : Apellido opcional}
                             {--uppercase : convierte a mayusculas bandera}'; // prefijo mas nombre algo descriptivo: {obligatorio} {--opcional} {--bandera}

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Muestra un saludo'; //descripcion

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $name = $this->argument("name");
        $lastName = $this->option("lastName");
        $uppercase = $this->option("uppercase");

        $message = "Bienvenido {$name} {$lastName}";

        if($uppercase){
            $message = strtoupper($message);
        }

        $this->info($message);
    }
}
