<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Plan extends Model
{
    protected $fillable = ['name', 'type', 'price', 'description']; //Datos que se guardan en la bd.

    //Un plan puede tener muchos productos
    public function products(): BelongsToMany {
        return $this->belongsToMany(Product::class);
    }

    //Un plan puede tener muchos contratos
    public function contracts(): BelongsToMany {
        return $this->belongsToMany(Contract::class);
    }
}