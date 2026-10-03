<?php

namespace App\Services\Agen;

use App\Models\Agent;
use App\Models\Gambar;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Throwable;

class ProfilServiceImpl implements ProfilService
{
    public function simpan(Agent $agent, array $data, ?UploadedFile $foto): void
    {
        $fotoLama = $agent->gambar;
        $fotoBaru = $foto?->store('agents/'.$agent->id, Gambar::DISK);

        try {
            DB::transaction(function () use ($agent, $data, $fotoBaru) {
                $agent->hasUser()->first()?->update(['name' => $data['name']]);

                $agent->forceFill([
                    'phone' => $data['phone'],
                    'alamat' => $data['alamat'] ?? null,
                    'kecamatan_id' => $data['kecamatan'] ?? null,
                    'about' => $data['about'] ?? null,
                ] + ($fotoBaru ? ['gambar' => $fotoBaru] : []))->save();
            });
        } catch (Throwable $e) {
            if ($fotoBaru) {
                Storage::disk(Gambar::DISK)->delete($fotoBaru);
            }
            throw $e;
        }

        if ($fotoBaru && $fotoLama) {
            Storage::disk(Gambar::DISK)->delete($fotoLama);
        }
    }
}
