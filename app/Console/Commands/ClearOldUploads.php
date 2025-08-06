<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\File;

class ClearOldUploads extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'maintenance:clear-old-uploads';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Elimina archivos viejos popr mantenimiento';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $folderPath = public_path("tempfiles");

        if(!File::exists($folderPath)){
            $this->error("No se encontro la carpeta: " . $folderPath);
            return Command::FAILURE;
        }

        $files = File::files($folderPath);

        foreach($files as $file){
            File::delete($file);
            $this->info("Eliminando: ".$file->getFilename());
        }

        $this->info("Limpieza de archivos por mantenimiento completada.");
    }
}
