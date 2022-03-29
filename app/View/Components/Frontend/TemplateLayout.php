<?php

namespace App\View\Components\Frontend;

use Illuminate\View\Component;

class TemplateLayout extends Component
{

    /**
     * GeoRestate v.2.0
     * Date: 29-03-2022
     * Author:AlexisDev
     * Email: alexistdev@gmail.com
     * Phone: 0823-7140-8678
     */

    public $judul;

    public function __construct($judul)
    {
        $this->judul = $judul;
    }

    public function render()
    {
        return view('components.frontend.template-layout');
    }
}
