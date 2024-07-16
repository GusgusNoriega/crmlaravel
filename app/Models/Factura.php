<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Factura extends Model
{
    use HasFactory;

    public function cotizaciones()
    {
        return $this->belongsToMany(Cotizacion::class, 'cotizacion_factura');
    }
}
