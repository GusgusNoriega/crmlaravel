<?php

namespace App\Models;

//use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class User extends Authenticatable /*implements MustVerifyEmail*/
{
    use HasApiTokens, HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
        'telefono',
        'cargo',
        'role_id',
        'image_id',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
        'password' => 'hashed',
    ];

    public function role()
    {
        return $this->belongsTo(Role::class);
    }
    
    public function image()
    {
        return $this->hasOne(Image::class, 'id', 'image_id');
    }

    public function clientes() {
        return $this->hasMany(Cliente::class);
    }

    public function empresas() {
        return $this->hasMany(Empresa::class);
    }

    public function cotizaciones()
    {
        return $this->hasMany(Cotizacion::class);
    }

    public function embudos()
    {
        return $this->hasMany(Embudo::class);
    }

    public function comentarios()
    {
        return $this->hasMany(Comentario::class);
    }

    public function comentariosAsignados()
    {
        return $this->hasMany(Comentario::class, 'user_asig_id');
    }

}
