<?php

namespace App\View\Components\terminos;

use Closure;
use Illuminate\Contracts\View\View;
use Illuminate\View\Component;

class agregarTermino extends Component
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
        return view('components.terminos.agregar-termino', [
            'elementoId' => $this->elementoId
        ]);
    }
}
