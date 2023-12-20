<?php

namespace App\Services\Admin;

use Illuminate\Http\Request;

interface DistrictService
{
    public function get_data_provinsi(Request $request);
    public function save_provinsi(Request $request);
    public function update_provinsi(Request $request);
}
