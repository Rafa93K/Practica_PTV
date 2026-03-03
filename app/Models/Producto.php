<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Producto extends Model
{
    protected $fillable = ['id', 'nombre', 'cantidad', 'precio']; //Datos que se guardan en la bd

    //Un producto puede estar en muchas tarifas
    public function tarifas(): BelongsToMany {
        return $this->belongsToMany(Tarifa::class);
    }
}