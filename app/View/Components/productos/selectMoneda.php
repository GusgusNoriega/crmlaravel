<?php

namespace App\View\Components\productos;

use Closure;
use Illuminate\Contracts\View\View;
use Illuminate\View\Component;
use App\Models\Moneda;

class selectMoneda extends Component
{
    public $monedas;
    public $selectId;

    public function __construct($selectId = null)
    {
        $this->monedas = Moneda::all(); // Obtener todas las monedas
        $this->selectId = $selectId;
    }

    /**
     * Get the view / contents that represent the component.
     */
    public function render(): View|Closure|string
    {
        return view('components.productos.select-moneda');
    }
}
