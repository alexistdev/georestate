<?php

namespace App\View\Components\Agent;

use Closure;
use Illuminate\Contracts\View\View;
use Illuminate\View\Component;

class AgentMenuSidebarLayout extends Component
{
    /**
     * Author: AlexistDev
     * Email: Alexistdev@gmail.com
     * Phone: 082371408678
     * Github: https://github.com/alexistdev
     */
    public $menuUtama;
    public $menuKedua;

    public function __construct($menuUtama,$menuKedua)
    {
        $this->menuUtama = $menuUtama;
        $this->menuKedua = $menuKedua;
    }

    public function render(): View|Closure|string
    {
        return view('components.agent.agent-menu-sidebar-layout');
    }
}