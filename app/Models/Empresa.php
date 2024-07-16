<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Empresa extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'email' ,
        'telefono',
        'ruc',
        'imagen_destacada' ,
        'user_id',     
    ];

    protected static function boot()
    {
        parent::boot();

        static::deleting(function ($empresa) {
            // Eliminar todos los comentarios asociados
            $empresa->comentarios()->delete();
        });
    }

    public function imagenDestacada() {
        return $this->belongsTo(Image::class, 'imagen_destacada');
    }

    public function user() {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function comentarios()
    {
        return $this->morphMany(Comentario::class, 'comentable');
    }

    public function sucursales() {
        return $this->hasMany(Sucursal::class, 'empresa_id');
    }

    public function empleados() {
        return $this->hasMany(Cliente::class, 'empresa_id');
    }
}