<?php

namespace App\View\Components;

use Closure;
use Illuminate\Contracts\View\View;
use Illuminate\View\Component;
use App\Models\User;

class Usuarios extends Component
{
    /**
     * Create a new component instance.
     */
    public function __construct()
    {
        //
    }

    /**
     * Get the view / contents that represent the component.
     */
    public function render(): View|Closure|string
    {
       // Obtener todos los usuarios con las imágenes cargadas
       $usuarios = User::with('image')->get();

        // Pasar los usuarios a la vista
        return view('components.usuarios', ['usuarios' => $usuarios]);
    }
}
