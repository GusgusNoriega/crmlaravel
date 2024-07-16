<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Procedencia extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'imagen_destacada',  
    ];
    
    public function imagenDestacada() {
        return $this->belongsTo(Image::class, 'imagen_destacada');
    }
    
    public function products()
    {
        return $this->belongsToMany(Product::class);
    }
}
