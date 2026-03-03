<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Incidencia extends Model
{

    protected $fillable = ['descripcion', 'estado', 'fecha']; //campos que se van a rellenar
    protected $casts = ['fecha' => 'date'];  //para que se convierta a un objeto de fecha al acceder a él
    public function cliente()
    {
        return $this->belongsTo(Cliente::class, 'cliente_id');
    }

    public function trabajador()
    {
        return $this->belongsTo(Trabajador::class, 'trabajador_id');
    }
}
