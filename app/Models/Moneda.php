<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Moneda extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'code',
        'symbol',
        'tipo_cambio',
    ];

    public function cotizaciones()
    {
        return $this->hasMany(Cotizacion::class);
    }
}
