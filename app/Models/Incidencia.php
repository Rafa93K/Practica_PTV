<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Incidencia extends Model
{

    protected $fillable = ['descripcion', 'estado', 'fecha_inicio', 'fecha_fin', 'intervalo_resolucion']; //campos que se van a rellenar
    protected $casts = ['fecha_inicio' => 'date', 'fecha_fin' => 'date'];  //para que se convierta a un objeto de fecha al acceder a él
    public function cliente()
    {
        return $this->belongsTo(Cliente::class, 'cliente_id');
    }

    public function trabajador()
    {
        return $this->belongsTo(Trabajadore::class, 'trabajador_id');
    }
}
