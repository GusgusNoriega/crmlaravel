<?php

namespace App\View\Components\productos;

use Closure;
use Illuminate\Contracts\View\View;
use Illuminate\View\Component;

class buscadorCategoria extends Component
{
    public $idPrincipal;
    public $nombre;
    public $cantidad;
    public $subcategorias;
    /**
     * Create a new component instance.
     * 
     */
    public function __construct($idPrincipal, $nombre, $cantidad, $subcategorias = false)
    {
        $this->idPrincipal = $idPrincipal;
        $this->nombre = $nombre;
        $this->cantidad = $cantidad;
        $this->subcategorias = $subcategorias;
    }

    /**
     * Get the view / contents that represent the component.
     */
    public function render(): View|Closure|string
    {
        return view('components.productos.buscador-categoria');
    }
}
