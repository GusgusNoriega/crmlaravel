<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Sucursal extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'direccion',     
        'empresa_id',     
    ];

    public function empresa() {
        return $this->belongsTo(Empresa::class, 'empresa_id');
    }
    public function clientes()
    {
        return $this->hasMany(Cliente::class);
    }
}
