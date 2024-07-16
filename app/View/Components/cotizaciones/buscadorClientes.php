<?php

namespace App\View\Components\cotizaciones;

use Closure;
use Illuminate\Contracts\View\View;
use Illuminate\View\Component;

class buscadorClientes extends Component
{
    public $idPrincipal;
    public $nombre;
    public $cantidad;
    /**
     * Create a new component instance.
     * 
     */
    public function __construct($idPrincipal, $nombre, $cantidad)
    {
        $this->idPrincipal = $idPrincipal;
        $this->nombre = $nombre;
        $this->cantidad = $cantidad;
    }

    /**
     * Get the view / contents that represent the component.
     */
    public function render(): View|Closure|string
    {
        return view('components.cotizaciones.buscador-clientes');
    }
}
