<?php

namespace App\View\Components\productos;

use Closure;
use Illuminate\Contracts\View\View;
use Illuminate\View\Component;

class slider extends Component
{
    public $imagenPrincipal;
    public $imagenes;

    /**
     * Create a new component instance.
     * 
     */
    public function __construct($imagenPrincipal, $imagenes = '')
    {
        $this->imagenPrincipal = $imagenPrincipal;
        $this->imagenes = $imagenes;
    }
    /**
     * Get the view / contents that represent the component.
     */
    public function render(): View|Closure|string
    {
        return view('components.productos.slider');
    }
}
