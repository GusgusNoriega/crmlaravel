<?php

namespace App\View\Components;

use Closure;
use Illuminate\Contracts\View\View;
use Illuminate\View\Component;
use App\Models\Role;

class RegistrationForm extends Component
{
   
    public $roles;

    public function __construct()
    {
        $this->roles = Role::select('id', 'name')->get();
    }

    /**
     * Get the view / contents that represent the component.
     */
    public function render(): View|Closure|string
    {
        return view('components.registration-form', [
            'roles' => $this->roles
        ]);
    }
}
