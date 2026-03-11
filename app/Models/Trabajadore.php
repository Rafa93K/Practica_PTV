<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Trabajadore extends Model
{
    protected $fillable = ['nombre', 'apellido', 'dni', 'telefono', 'email','contraseña','rol']; //Campos que se van a rellenar
    protected $casts = ['contraseña' => 'hashed']; //Para que se encripte la contraseña


    public function incidencias()
    {
        return $this->hasMany(Incidencia::class, 'trabajador_id');
    }



}
