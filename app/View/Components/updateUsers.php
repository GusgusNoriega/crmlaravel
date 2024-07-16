<?php

namespace App\View\Components;

use Closure;
use Illuminate\Contracts\View\View;
use Illuminate\View\Component;
use App\Models\Role;

class updateUsers extends Component
{
    /**
     * Create a new component instance.
     */
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
        return view('components.update-users', [
            'roles' => $this->roles
        ]);
    }
}
