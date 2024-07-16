<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Taxonomia extends Model
{
    use HasFactory;

    // Campos asignables masivamente
    protected $fillable = ['name', 'slug', 'descripcion'];

    // Relación con Termino
    public function terminos()
    {
        return $this->hasMany(Termino::class);
    }

    // Método boot para generar automáticamente el slug
    protected static function boot()
    {
        parent::boot();

        static::saving(function ($taxonomia) {
            $baseSlug = \Str::slug($taxonomia->name);
            $slug = $baseSlug;
            $count = 1;

            // Mientras el slug exista en la base de datos, añade o incrementa un sufijo numérico
            while (static::whereSlug($slug)->exists()) {
                $slug = $baseSlug . '-' . $count++;
             }

            $taxonomia->slug = $slug;
         });
    }

    public function products()
    {
        return $this->belongsToMany(Product::class, 'product_taxonomia');
    }
}
