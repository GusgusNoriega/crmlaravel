<?php

namespace App\View\Components\cotizaciones;

use Closure;
use Illuminate\Contracts\View\View;
use Illuminate\View\Component;
use App\Models\Misempresa;

class selectMisEmpresas extends Component
{

    public $misempresas;
    public $selectId;
    /**
     * Create a new component instance.
     */
    public function __construct($selectId = null)
    {
        $this->misempresas = Misempresa::all(); // Obtener todas las monedas
        $this->selectId = $selectId;
    }

    /**
     * Get the view / contents that represent the component.
     */
    public function render(): View|Closure|string
    {
        return view('components.cotizaciones.select-mis-empresas');
    }
}
