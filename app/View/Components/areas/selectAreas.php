<?php

namespace App\View\Components\areas;

use Closure;
use Illuminate\Contracts\View\View;
use Illuminate\View\Component;
use App\Models\Area;

class selectAreas extends Component
{
    public $areas;
    public $selectId;

    public function __construct($selectId = null)
    {
        $this->areas = Area::all(); // Obtener todas las monedas
        $this->selectId = $selectId;
    }

    /**
     * Get the view / contents that represent the component.
     */
    public function render(): View|Closure|string
    {
        return view('components.areas.select-areas');
    }
}
