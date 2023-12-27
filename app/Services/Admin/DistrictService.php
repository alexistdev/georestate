<?php

namespace App\Services\Admin;

use Illuminate\Http\Request;

interface DistrictService
{
    /**
     * Provinsi
     */
    public function get_data_provinsi(Request $request);
    public function save_provinsi(Request $request);
    public function update_provinsi(Request $request);
    public function delete_provinsi(int $id);

    /**
     * Kabupaten
     */
    public function get_data_kabupaten(Request $request);
    public function save_kabupaten(Request $request);
}
