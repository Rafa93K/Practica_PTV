<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Contrato extends Model
{
    protected $fillable = ['cliente_id', 'trabajador_id', 'ciudad', 'provincia', 'calle', 'numero', 'puerta', 'codigo_postal']; //Datos que se guardan en la bd

    //Un contrato pertenece a un cliente
    public function cliente(): BelongsTo {
        return $this->belongsTo(Cliente::class, 'cliente_id');
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
