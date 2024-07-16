<?php

namespace App\View\Components\sucursales;

use Closure;
use Illuminate\Contracts\View\View;
use Illuminate\View\Component;

class todosSucursales extends Component
{
    public $idElemento;

    public function __construct($idElemento = null)
    {
        $this->idElemento = $idElemento;
    }

    public function render(): View|Closure|string
    {
        return view('components.sucursales.todos-sucursales', [
            'idElemento' => $this->idElemento
        ]);
    }

}
