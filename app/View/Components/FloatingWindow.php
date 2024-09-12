<?php

namespace App\View\Components;

use Closure;
use Illuminate\Contracts\View\View;
use Illuminate\View\Component;

class FloatingWindow extends Component
{
    /**
     * Create a new component instance.
     */
    public string $title;
    public string $btnName;
    public function __construct($title, $btnName)
    {
        $this->title = $title;
        $this->btnName = $btnName;
    }

    /**
     * Get the view / contents that represent the component.
     */
    public function render(): View|Closure|string
    {
        return view('components.floating-window');
    }
}
