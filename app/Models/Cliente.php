<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Cliente extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'email' ,
        'telefono',
        'direccion' ,
        'ruc',
        'imagen_destacada' ,
        'user_id',  
        'tipo',  
        'empresa_id',
        'sucursal_id',
        'cargo',
        'area_id',
    ];
    
    public function imagenDestacada() {
        return $this->belongsTo(Image::class, 'imagen_destacada');
    }
    
    public function user() {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function empresa() {
        return $this->belongsTo(Empresa::class, 'empresa_id');
    }

    public function cotizaciones()
    {
        return $this->hasMany(Cotizacion::class);
    }

    public function area()
    {
        return $this->belongsTo(Area::class);
    }

    public function sucursal()
    {
        return $this->belongsTo(Sucursal::class);
    }
}
