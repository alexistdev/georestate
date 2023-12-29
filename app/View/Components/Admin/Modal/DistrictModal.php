<?php

namespace App\View\Components\Admin\Modal;

use Closure;
use Illuminate\Contracts\View\View;
use Illuminate\View\Component;

class DistrictModal extends Component
{
    public $dataProvinsi;
    public $dataKabupaten;

    public function __construct($dataProvinsi,$dataKabupaten)
    {
        $this->dataProvinsi = $dataProvinsi;
        $this->dataKabupaten = $dataKabupaten;
    }

    /**
     * Get the view / contents that represent the component.
     */
    public function render(): View|Closure|string
    {
        return view('components.admin.modal.district-modal');
    }
}
