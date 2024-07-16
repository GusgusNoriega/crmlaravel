<?php

namespace App\View\Components;

use Closure;
use Illuminate\Contracts\View\View;
use Illuminate\View\Component;
use App\Models\Image;

class selectImages extends Component
{
    public $images;

    public function __construct()
    {
        $this->images = Image::latest()->paginate(20); // Paginar las imágenes, 10 por página
    }

    public function render()
    {
        return view('components.select-images', [
            'images' => $this->images,
        ]);
    }
}
