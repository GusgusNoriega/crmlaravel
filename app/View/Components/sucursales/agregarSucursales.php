<?php

namespace App\View\Components\sucursales;

use Closure;
use Illuminate\Contracts\View\View;
use Illuminate\View\Component;

class agregarSucursales extends Component
{
    public $elementoId;
    /**
     * Create a new component instance.
     */
    public function __construct($elementoId = null)
    {
        $this->elementoId = $elementoId;
    }

    /**
     * Get the view / contents that represent the component.
     */
    public function render(): View|Closure|string
    {
        return view('components.sucursales.agregar-sucursales', [
            'elementoId' => $this->elementoId
        ]);
    }
}