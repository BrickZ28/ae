<?php

namespace App\View\Components;

use Illuminate\View\Component;

class SideMenuItems extends Component
{
    public $link;
    public $icon;
    public $title;

    public function __construct($link, $icon, $title)
    {
        $this->link = $link;
        $this->icon = $icon;
        $this->title = $title;
    }

    public function render()
    {
        return view('components.side-menu-items');
    }
}
