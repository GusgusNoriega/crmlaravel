<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Embudo extends Model
{
    use HasFactory;

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function columnas()
    {
        return $this->belongsToMany(Columna::class, 'columna_embudo')
                    ->withPivot('posicion')
                    ->withTimestamps();
    }
}
