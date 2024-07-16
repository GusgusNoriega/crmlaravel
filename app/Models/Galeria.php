<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Galeria extends Model
{
    use HasFactory;
    
    public function images()
    {
        return $this->belongsToMany(Image::class, 'galeria_image');
    }

    public function products()
    {
        return $this->hasMany(Product::class);
    }
}
