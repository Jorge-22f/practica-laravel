<?php

namespace App\Console\Commands;

use App\Models\Product;
use Illuminate\Console\Command;

class ProductInfo extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:product-info {id : id del producto a consultar}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Descripcion de un producto ';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $id = $this->argument("id");

        $product = Product::find($id);

        if(!is_numeric($id) || $id <= 0){
            $this->error("error: El Id debe ser un numero positivo.");
            return Command::FAILURE;
        }

        if(!$product){
            $this->error("El producto no existe");
            return Command::FAILURE; // indica que fallo y no continua
        }

        $this->info("*** Producto encontrado ***");
        $this->info("Nombre: {$product->name}");
        $this->info("Descripcion: {$product->description}");
        $this->info("Precio: {$product->price}");
    }
}
