<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Incidence extends Model
{

    protected $fillable = ['description', 'status', 'date']; //campos que se van a rellenar
    protected $casts = ['date' => 'date'];  //para que se convierta a un objeto de fecha al acceder a él
    public function cliente()
    {
        return $this->belongsTo(Client::class, 'cliente_id');
    }

    public function worker()
    {
        return $this->belongsTo(Worker::class, 'worker_id');
    }
}
