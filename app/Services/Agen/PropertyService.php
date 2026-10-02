<?php

namespace App\Services\Agen;

use App\Models\Agent;
use App\Models\Gambar;
use App\Models\Property;
use Illuminate\Http\UploadedFile;

interface PropertyService
{
    /**
     * @param  array<string, mixed>  $data  data tervalidasi dari PropertyRequest
     * @param  array<int, UploadedFile>  $gambar
     */
    public function save(Agent $agent, array $data, array $gambar): Property;

    /**
     * Mengubah listing; status kembali menunggu persetujuan admin.
     *
     * @param  array<string, mixed>  $data
     * @param  array<int, UploadedFile>  $gambar  foto tambahan
     */
    public function update(Property $property, array $data, array $gambar): Property;

    public function delete(Property $property): void;

    public function deleteGambar(Gambar $gambar): void;

    public function setGambarUtama(Gambar $gambar): void;
}
