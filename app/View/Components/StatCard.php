<?php

namespace App\View\Components;

use Illuminate\View\Component;

class StatCard extends Component
{
    public $color;
    public $icon;
    public $number;
    public $label;

    /**
     * Create a new component instance.
     *
     * @return void
     */
    public function __construct($color = 'blue', $icon = 'fa-chart-bar', $number = 0, $label = '')
    {
        $this->color  = $color;
        $this->icon   = $icon;
        $this->number = $number;
        $this->label  = $label;
    }

    /**
     * Get the view / contents that represent the component.
     *
     * @return \Illuminate\Contracts\View\View|\Closure|string
     */
    public function render()
    {
        return view('components.stat-card');
    }
}