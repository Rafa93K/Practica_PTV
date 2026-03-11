<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Tarifa extends Model
{
    protected $fillable = ['nombre', 'tipo', 'precio', 'descripcion']; //Datos que se guardan en la bd

    //Una tarifa puede tener muchos productos
    public function productos(): BelongsToMany {
        return $this->belongsToMany(Producto::class, 'tarifa_producto');
    }

    //Un plan puede tener muchos contratos
    public function contratos(): BelongsToMany {
        return $this->belongsToMany(Contrato::class);
    }
}