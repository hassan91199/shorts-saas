<?php

namespace App\View\Components;

use Illuminate\View\Component;
use Illuminate\View\View;

class AppLayout extends Component
{
    public $pageTitle;

    public function __construct($pageTitle = 'Please set the page title')
    {
        $this->pageTitle = $pageTitle;
    }

    /**
     * Get the view / contents that represents the component.
     */
    public function render(): View
    {
        return view('layouts.app');
    }
}
