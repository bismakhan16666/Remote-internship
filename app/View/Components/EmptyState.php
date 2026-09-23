<?php

namespace App\View\Components;

use Illuminate\View\Component;

class EmptyState extends Component
{
    public $icon;
    public $message;

    public function __construct($icon = 'fa-inbox', $message = 'No data found')
    {
        $this->icon    = $icon;
        $this->message = $message;
    }

    public function render()
    {
        return view('components.empty-state');
    }
}