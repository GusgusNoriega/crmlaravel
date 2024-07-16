<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Categoria extends Model
{
    use HasFactory;
    protected $fillable = [
        'name',
        'imagen_destacada',
        'categoria_padre_id',
    ];
    public function categoriaPadre() {
        return $this->belongsTo(Categoria::class, 'categoria_padre_id');
    }

    public function subcategorias() {
        return $this->hasMany(Categoria::class, 'categoria_padre_id');
    }

    public function products() {
        return $this->belongsToMany(Product::class, 'categoria_product');
    }

    public function imagenDestacada() {
        return $this->belongsTo(Image::class, 'imagen_destacada');
    }
}