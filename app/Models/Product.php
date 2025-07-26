<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\SoftDeletes;

class Product extends Model
{
    use HasFactory, SoftDeletes; //softDeletes me habilita el borrado logico

    protected $table = 'product';

    protected $fillable = ["name", "description", "price", "category_id"];

    protected $hidden = [ //este apartado oculta lo que se desee del modelo
        "created_at",
        "updated_at",
    ];

    public function category(){
        return $this->belongsTo(Category::class);
    }
}
