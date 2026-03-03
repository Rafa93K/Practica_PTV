<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;


class Client extends Model
{
    
    protected $fillable = ['name', 'surname', 'dni', 'phone', 'email','password']; //campos que se van a rellenar

    protected $casts = ['password' => 'hashed']; //para que se encripte la contraseña

    public function incidences():HasMany
    {
        return $this->hasMany(Incidence::class, 'client_id');
    }
}
