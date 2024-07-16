<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Apiweb extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'web',
        'clave_key',
        'clave_secret',
        'tipo',
        'alias',
    ];

}
