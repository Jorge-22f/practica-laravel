<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Faker\Factory as Faker;

class ProductTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $fake = Faker::create();

        $categoryIds = DB::table("category")->pluck("id")->toArray();

        if(empty($categoryIds)){
            $this->command->warn("No hay categorias en la tabla category");
            return;
        }

        $products = [];

        for ($i = 1; $i <= 50; $i++){
            $products[] = [
                'name' => 'producto ' .$i, //$fake->word,
                'description' => $fake->sentence,
                'price' => rand(100, 1000), // $fake->randomFloat(2, 100, 1000)
                'category_id' => $fake->randomElement($categoryIds), //$categoryIds[array_rand($categoryIds)]
                'created_at' => now(),
                'updated_at' => now(),
            ];
        }

        DB::table("product")->insert($products);
    }
}
