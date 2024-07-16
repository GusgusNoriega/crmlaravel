<?php

namespace App\View\Components;

use Closure;
use Illuminate\Contracts\View\View;
use Illuminate\View\Component;
use App\Models\User;

class UserSelectVendedor extends Component
{
    
    public $users;
    public $selectId;

    public function __construct($selectId = null)
    {
        $this->users = User::all(); // Obtener todos los usuarios
        $this->selectId = $selectId;
    }
    /**
     * Get the view / contents that represent the component.
     */
    public function render(): View|Closure|string
    {
        return view('components.user-select-vendedor');
    }
}
