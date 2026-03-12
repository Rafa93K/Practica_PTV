<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Factura extends Model
{
    protected $fillable = [
        'cliente_id',
        'contrato_id',
        'precio',
        'fecha_inicio',      
    ];

    public function cliente() {
        return $this->belongsTo(Cliente::class, 'cliente_id');
    }

    public function contrato(): BelongsTo {
        return $this->belongsTo(Contrato::class, 'contrato_id');
    }
}