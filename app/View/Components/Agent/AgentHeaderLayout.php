<?php

namespace App\View\Components\Agent;

use Closure;
use Illuminate\Contracts\View\View;
use Illuminate\View\Component;

class AgentHeaderLayout extends Component
{
    /**
     * Author: AlexistDev
     * Email: Alexistdev@gmail.com
     * Phone: 082371408678
     * Github: https://github.com/alexistdev
     */

    public function __construct()
    {
        //
    }

    public function render(): View|Closure|string
    {
        return view('components.agent.agent-header-layout');
    }
}
