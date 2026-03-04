<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;


class Cliente extends Model
{
    
    protected $fillable = ['nombre', 'apellido', 'dni', 'telefono', 'email','contraseña']; //campos que se van a rellenar

    protected $casts = ['contraseña' => 'hashed']; //para que se encripte la contraseña

    public function incidencias():HasMany
    {
        return $this->hasMany(Incidencia::class, 'cliente_id');
    }

    public function contratos(): HasMany
    {
        return $this->hasMany(Contrato::class, 'cliente_id');
    }

    public function facturas(): HasMany
    {
        return $this->hasMany(Factura::class, 'cliente_id');
    }
}
