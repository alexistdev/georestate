<?php

namespace App\Services\Admin;

use App\Models\Property;

interface ModerasiService
{
    /**
     * Setujui listing sehingga tayang di website.
     */
    public function approve(Property $property): void;

    /**
     * Tolak (atau turunkan) listing dengan alasan yang akan dilihat agen.
     */
    public function reject(Property $property, string $alasan): void;
}
