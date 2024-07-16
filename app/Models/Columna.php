<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Columna extends Model
{
    use HasFactory;

    public function embudos()
    {
        return $this->belongsToMany(Embudo::class, 'columna_embudo')
                    ->withPivot('posicion')
                    ->withTimestamps();
    }
}
