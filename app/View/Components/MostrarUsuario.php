<?php

namespace App\View\Components;

use Closure;
use Illuminate\Contracts\View\View;
use Illuminate\View\Component;
use Illuminate\Support\Facades\Auth;

class MostrarUsuario extends Component
{
    public $usuario;

    public function __construct()
    {
        $this->usuario = Auth::user()->load('image');
    }

    public function render()
    {
        return view('components.mostrar-usuario');
    }
}
