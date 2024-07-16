<?php

namespace App\View\Components\sucursales;

use Closure;
use Illuminate\Contracts\View\View;
use Illuminate\View\Component;

class sucursalPorEmpresa extends Component
{
    public $elementoId;

    public function __construct($elementoId = null)
    {
        $this->elementoId = $elementoId;
    }

    /**
     * Get the view / contents that represent the component.
     */
    public function render(): View|Closure|string
    {
        return view('components.sucursales.sucursal-por-empresa', [
            'elementoId' => $this->elementoId
        ]);
    }
}
