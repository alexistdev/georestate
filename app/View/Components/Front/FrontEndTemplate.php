<?php

namespace App\View\Components\Front;

use Closure;
use Illuminate\Contracts\View\View;
use Illuminate\View\Component;

class FrontEndTemplate extends Component
{
    /**
         * Author: AlexistDev
         * Email: Alexistdev@gmail.com
         * Phone: 082371408678
         * Github: https://github.com/alexistdev
         */

    public $title;
    public $mainLabel;
    public $secondaryLabel;

    public function __construct($title,$mainLabel=null,$secondaryLabel=null)
    {
       $this->title = $title;
       $this->mainLabel = $mainLabel;
       $this->secondaryLabel = $secondaryLabel;
    }


    public function render(): View|Closure|string
    {
        return view('components.front.front-end-template');
    }
}
