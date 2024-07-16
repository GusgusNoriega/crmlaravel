<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Misempresa extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'ruc' ,
        'slug',
        'alias' ,
        'telefono',
        'imagen_logo' ,
        'imagen_sello',
        'cuenta_soles',
        'cuenta_dolares' ,
        'cuenta_nacion' ,
       
    ];

    public function imagenLogo()
    {
        return $this->belongsTo(Image::class, 'imagen_logo');
    }

    public function imagenSello()
    {
        return $this->belongsTo(Image::class, 'imagen_sello');
    }

    public function cotizaciones()
    {
        return $this->hasMany(Cotizacion::class);
    }
}
