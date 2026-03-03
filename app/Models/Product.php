<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Product extends Model
{
    protected $fillable = ['id', 'name', 'amount', 'price']; //Datos que se guardan en la bd

    //Un producto puede estar en muchos planes
    public function plans(): BelongsToMany {
        return $this->belongsToMany(Plan::class);
    }
}