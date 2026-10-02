<?php

namespace App\Services\Agen;

use App\Enums\PropertyStatus;
use App\Models\Agent;
use App\Models\Gambar;
use App\Models\Property;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Throwable;

class PropertyServiceImpl implements PropertyService
{
    public function save(Agent $agent, array $data, array $gambar): Property
    {
        return $this->withUploadedFiles(function (array &$paths) use ($agent, $data, $gambar) {
            $property = new Property($this->attributes($data));
            $property->agent_id = $agent->id;
            $property->save();

            $property->fasilitas()->sync($data['fasilitas'] ?? []);
            $this->storeGambar($property, $gambar, $paths);

            return $property;
        });
    }

    public function update(Property $property, array $data, array $gambar): Property
    {
        return $this->withUploadedFiles(function (array &$paths) use ($property, $data, $gambar) {
            $property->fill($this->attributes($data));
            $property->status = PropertyStatus::Pending;
            $property->alasan_penolakan = null;
            $property->approved_at = null;
            $property->save();

            $property->fasilitas()->sync($data['fasilitas'] ?? []);
            $this->storeGambar($property, $gambar, $paths);

            return $property;
        });
    }

    public function delete(Property $property): void
    {
        // Soft delete: foto tetap disimpan agar listing bisa dipulihkan admin.
        $property->delete();
    }

    public function deleteGambar(Gambar $gambar): void
    {
        DB::transaction(function () use ($gambar) {
            $property = $gambar->property;
            $wasDefault = $gambar->isDefault;
            $gambar->forceDelete();

            if ($wasDefault) {
                $property->gambars()->first()?->update(['isDefault' => true]);
            }
        });

        Storage::disk(Gambar::DISK)->delete($gambar->name);
    }

    public function setGambarUtama(Gambar $gambar): void
    {
        DB::transaction(function () use ($gambar) {
            Gambar::where('property_id', $gambar->property_id)->update(['isDefault' => false]);
            $gambar->update(['isDefault' => true]);
        });
    }

    /**
     * Petakan field form ke kolom tabel properties.
     */
    private function attributes(array $data): array
    {
        return [
            'name' => $data['name'],
            'description' => $data['description'] ?? null,
            'kategori_id' => $data['kategori'],
            'kecamatan_id' => $data['kecamatan'],
            'address' => $data['address'] ?? null,
            'lt' => $data['lt'],
            'lb' => $data['lb'],
            'beds' => $data['kamar_tidur'] ?? 0,
            'baths' => $data['kamar_mandi'] ?? 0,
            'harga_harian' => $data['harga_harian'] ?? null,
            'harga_bulanan' => $data['harga_bulanan'] ?? null,
            'harga_tahunan' => $data['harga_tahunan'] ?? null,
        ];
    }

    /**
     * @param  array<int, UploadedFile>  $files
     * @param  array<int, string>  $paths  path yang tersimpan (untuk dibersihkan jika gagal)
     */
    private function storeGambar(Property $property, array $files, array &$paths): void
    {
        $adaDefault = $property->gambars()->where('isDefault', true)->exists();

        foreach ($files as $file) {
            $path = $file->store('properties/'.$property->id, Gambar::DISK);
            $paths[] = $path;

            $property->gambars()->create([
                'name' => $path,
                'isDefault' => !$adaDefault,
            ]);
            $adaDefault = true;
        }
    }

    /**
     * Jalankan dalam transaksi; jika gagal, hapus file yang terlanjur diupload.
     */
    private function withUploadedFiles(callable $callback): Property
    {
        $paths = [];
        try {
            return DB::transaction(function () use ($callback, &$paths) {
                return $callback($paths);
            });
        } catch (Throwable $e) {
            Storage::disk(Gambar::DISK)->delete($paths);
            throw $e;
        }
    }
}
