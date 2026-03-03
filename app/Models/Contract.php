<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Contract extends Model
{
    protected $fillable = ['client_id', 'product_id', 'start_date']; //Datos que se guardan en la bd

    //Un contrato pertenece a un cliente
    public function clients(): BelongsToMany {
        return $this->belongsToMany(Client::class);
    }

    //Un contrato puede tener muchos planes
    public function plans(): BelongsToMany {
        return $this->belongsToMany(Plan::class);
    }

    //Un contrato puede tener muchas facturas
    public function invoices(): HasMany {
        return $this->hasMany(Invoice::class);
    }
}
