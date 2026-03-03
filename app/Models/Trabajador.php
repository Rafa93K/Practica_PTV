<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Trabajador extends Model
{
    protected $fillable = ['nombre', 'apellido', 'dni', 'telefono', 'email','contraseña','rol']; //campos que se van a rellenar
    protected $casts = ['contraseña' => 'hashed']; //para que se encripte la contraseña


    public function incidencias()
    {
        return $this->hasMany(Incidencia::class, 'trabajador_id');
    }



}
