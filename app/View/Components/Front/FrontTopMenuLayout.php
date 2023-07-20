<?php

namespace App\View\Components\Front;

use Closure;
use Illuminate\Contracts\View\View;
use Illuminate\View\Component;

class FrontTopMenuLayout extends Component
{
    /**
         * Author: AlexistDev
         * Email: Alexistdev@gmail.com
         * Phone: 082371408678
         * Github: https://github.com/alexistdev
         */

    public $mainLabel;

    public function __construct($mainLabel)
    {
        $this->mainLabel = $mainLabel;
    }


    public function render(): View|Closure|string
    {
        return view('components.front.front-top-menu-layout');
    }
}
