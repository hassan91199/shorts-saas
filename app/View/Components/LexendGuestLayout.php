<?php

namespace App\View\Components;

use Illuminate\View\Component;
use Illuminate\View\View;

class LexendGuestLayout extends Component
{
    public $showMenuPanel;
    public $showBottomActionsSticky;
    public $showHeader;
    public $showFooter;

    public function __construct($showMenuPanel = true, $showBottomActionsSticky = true, $showHeader = true, $showFooter = true)
    {
        $this->showMenuPanel = $showMenuPanel;
        $this->showBottomActionsSticky = $showBottomActionsSticky;
        $this->showHeader = $showHeader;
        $this->showFooter = $showFooter;
    }

    /**
     * Get the view / contents that represents the component.
     */
    public function render(): View
    {
        return view('layouts.lexend-guest');
    }
}
