<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Worker extends Model
{
    protected $fillable = ['name', 'surname', 'dni', 'phone', 'email','password','role']; //campos que se van a rellenar
    protected $casts = ['password' => 'hashed']; //para que se encripte la contraseña


    public function incidences()
    {
        return $this->hasMany(Incidence::class, 'worker_id');
    }



}
