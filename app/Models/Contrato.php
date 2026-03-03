<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Contrato extends Model
{
    protected $fillable = ['cliente_id', 'trabajador_id', 'ciudad', 'provincia', 'calle', 'numero', 'puerta', 'codigo_postal', 'aprobado']; //Datos que se guardan en la bd

    //Un contrato pertenece a un cliente
    public function clientes(): BelongsToMany {
        return $this->belongsToMany(Cliente::class);
    }

    //Un contrato puede tener muchas tarifas
    public function tarifas(): BelongsToMany {
        return $this->belongsToMany(Tarifa::class);
    }

    //Un contrato puede tener muchas facturas
    public function facturas(): HasMany {
        return $this->hasMany(Factura::class);
    }
}
