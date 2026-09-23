<?php

namespace App\View\Components;

use Illuminate\View\Component;

class StatusBadge extends Component
{
    public $status;

    public function __construct($status = 'active')
    {
        $this->status = $status;
    }

    public function render()
    {
        return view('components.status-badge');
    }
}