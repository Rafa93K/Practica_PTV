<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Invoice extends Model
{
    protected $fillable = [
        'price',
        'start_date',      
    ];

    public function client()
    {
        return $this->belongsTo(Client::class, 'cliente_id');
    }

    public function contract():HasMany
    {
        return $this->hasMany(Contract::class, 'contract_id');
    }
}
