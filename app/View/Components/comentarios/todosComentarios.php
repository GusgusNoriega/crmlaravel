<?php

namespace App\View\Components\comentarios;

use Closure;
use Illuminate\Contracts\View\View;
use Illuminate\View\Component;

class todosComentarios extends Component
{
    public $idElemento;
    public $rutaModelo;

    /**
     * Create a new component instance.
     *
     * @param  mixed  $idElemento
     * @param  string  $rutaModelo
     */
    public function __construct($idElemento, $rutaModelo)
    {
        $this->idElemento = $idElemento;
        $this->rutaModelo = $rutaModelo;
    }

    /**
     * Get the view / contents that represent the component.
     */
    public function render(): View|Closure|string
    {
        return view('components.comentarios.todos-comentarios');
    }
}
