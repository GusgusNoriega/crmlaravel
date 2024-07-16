<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Termino extends Model
{
    use HasFactory;

    // Campos asignables masivamente
    protected $fillable = ['taxonomia_id', 'slug', 'name', 'descripcion'];

    // Relación con Termino
    public function taxonomia()
    {
        return $this->belongsTo(Taxonomia::class);
    }

    // Método boot para generar automáticamente el slug
    protected static function boot()
    {
        parent::boot();

        static::saving(function ($termino) {
            $baseSlug = \Str::slug($termino->name);
            $slug = $baseSlug;
            $count = 1;

            // Mientras el slug exista en la base de datos, añade o incrementa un sufijo numérico
            while (static::whereSlug($slug)->exists()) {
                $slug = $baseSlug . '-' . $count++;
            }

            $termino->slug = $slug;
        });
    }

    public function products()
    {
        return $this->belongsToMany(Product::class, 'product_termino');
    }
}
