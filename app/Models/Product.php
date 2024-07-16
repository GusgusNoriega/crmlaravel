<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    use HasFactory;
    
    protected $fillable = [
        'title', 'sku', 'modelo', 'moneda', 'precio', 'description', 'cont_envio', 'imagen_destacada', 'galeria_id', 'sku_ref', 'datos_tecnicos', 'tipo'
    ];

    public function categorias() {
        return $this->belongsToMany(Categoria::class, 'categoria_product');
    }

    public function imagenDestacada() {
        return $this->belongsTo(Image::class, 'imagen_destacada');
    }

    public function apiweb() {
        return $this->belongsTo(Apiweb::class, 'apiweb_id');
    }

    public function galeria()
    {
        return $this->belongsTo(Galeria::class);
    }

    public function marcas()
    {
        return $this->belongsToMany(Marca::class);
    }

    public function procedencias()
    {
        return $this->belongsToMany(Procedencia::class, 'procedencia_product');
    }

    public function monedaRelacionada()
    {
        return $this->belongsTo(Moneda::class, 'moneda', 'id');
    }

    public function cotizaciones()
    {
        return $this->belongsToMany(Cotizacion::class, 'cotizacion_product')
                    ->withPivot(['tipo_cambio_actual', 'tipo_cambio_final', 'precio_actual', 'precio_final', 'moneda_actual', 'moneda_final', 'cantidad', 'precio_descuento']); // especifica aquí todos los campos adicionales
    }

    public function taxonomias()
    {
        return $this->belongsToMany(Taxonomia::class, 'product_taxonomia');
    }

    public function terminos()
    {
        return $this->belongsToMany(Termino::class, 'product_termino');
    }
}

