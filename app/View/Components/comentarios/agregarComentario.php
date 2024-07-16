<?php

namespace App\View\Components\comentarios;

use Closure;
use Illuminate\Contracts\View\View;
use Illuminate\View\Component;

class agregarComentario extends Component
{
    public $elementoId;
    public $modeloType;
    /**
     * Create a new component instance.
     */
    public function __construct($elementoId = null, $modeloType = null)
    {
        $this->elementoId = $elementoId;
        $this->modeloType = $modeloType;
    }

    /**
     * Get the view / contents that represent the component.
     */
    public function render(): View|Closure|string
    {
        return view('components.comentarios.agregar-comentario', [
            'elementoId' => $this->elementoId,
            'modeloType' => $this->modeloType
        ]);
    }
}
