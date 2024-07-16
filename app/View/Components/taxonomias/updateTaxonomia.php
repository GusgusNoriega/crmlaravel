<?php

namespace App\View\Components\taxonomias;

use Closure;
use Illuminate\Contracts\View\View;
use Illuminate\View\Component;

class updateTaxonomia extends Component
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
        return view('components.taxonomias.update-taxonomia');
    }
}
