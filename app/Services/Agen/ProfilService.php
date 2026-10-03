<?php

namespace App\Services\Agen;

use App\Models\Agent;
use Illuminate\Http\UploadedFile;

interface ProfilService
{
    /**
     * Simpan data diri agen; jika ada foto baru, foto lama dihapus dari storage.
     *
     * @param  array<string, mixed>  $data  data tervalidasi dari ProfilRequest
     */
    public function simpan(Agent $agent, array $data, ?UploadedFile $foto): void;
}
