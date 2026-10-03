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

    /** Deskripsi & gambar untuk SEO / pratinjau tautan (Open Graph). */
    public ?string $description;
    public ?string $image;

    public function __construct($title,$mainLabel=null,$secondaryLabel=null,$description=null,$image=null)
    {
       $this->title = $title;
       $this->mainLabel = $mainLabel;
       $this->secondaryLabel = $secondaryLabel;
       $this->description = $description;
       $this->image = $image;
    }


    public function render(): View|Closure|string
    {
        return view('components.front.front-end-template');
    }
}
