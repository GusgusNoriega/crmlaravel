<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Comentario extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'contenido',
        'comentable_id',
        'comentable_type',
        'user_asig_id',
        'fecha_asignada',
        'fecha_culminacion',
        'complete', 
    ];

    public function comentable()
    {
        return $this->morphTo();
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function userAsignado()
    {
        return $this->belongsTo(User::class, 'user_asig_id');
    }
} 
