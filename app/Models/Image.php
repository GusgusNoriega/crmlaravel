<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Image extends Model
{
    use HasFactory;
    protected $fillable = ['name', 'ruta', 'alt', 'ruta_anterior'];
    
    public function user()
    {
        return $this->belongsTo(User::class, 'image_id', 'id');
    }
    
    public function galerias()
    {
        return $this->belongsToMany(Galeria::class, 'galeria_image');
    }

    public function empresaComoLogo()
    {
        return $this->hasOne(MisEmpresa::class, 'imagen_logo');
    }

    public function empresaComoSello()
    {
        return $this->hasOne(MisEmpresa::class, 'imagen_sello');
    }

}