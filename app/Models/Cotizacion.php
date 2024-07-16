<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Cotizacion extends Model
{
    use HasFactory;

    protected $fillable = [
        'nro_cotizacion',
        'fecha_cotizacion',
        'fecha_vencimiento',
        'entrega' ,
        'lugar_entrega',
        'garantia' ,
        'tipo_de_cambio',
        'adicionales',
        'total_productos',
        'forma_de_pago',
        'total',
        'misempresa_id',
        'user_id',
        'cliente_id',
        'moneda_id',
    ];

    protected $casts = [
        'fecha_cotizacion' => 'datetime',
        'fecha_vencimiento' => 'datetime',
    ];

    public function misempresa()
    {
        return $this->belongsTo(Misempresa::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function cliente()
    {
        return $this->belongsTo(Cliente::class);
    }
    
    public function moneda()
    {
        return $this->belongsTo(Moneda::class);
    }

    public function products()
    {
        return $this->belongsToMany(Product::class, 'cotizacion_product')
        ->withPivot(['tipo_cambio_actual', 'tipo_cambio_final', 'precio_actual', 'precio_final', 'moneda_actual', 'moneda_final', 'cantidad', 'precio_descuento']); // especifica aquí todos los campos adicionales
    }

   
    public function facturas()
    {
        return $this->belongsToMany(Factura::class, 'cotizacion_factura');
    }
}
