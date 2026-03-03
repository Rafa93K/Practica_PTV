<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Factura extends Model
{
    protected $fillable = [
        'precio',
        'fecha_inicio',      
    ];

    public function cliente()
    {
        return $this->belongsTo(Cliente::class, 'cliente_id');
    }

    public function contracto():HasMany
    {
        return $this->hasMany(Contrato::class, 'contracto_id');
    }
}
