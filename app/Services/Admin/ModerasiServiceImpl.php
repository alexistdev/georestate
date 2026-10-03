<?php

namespace App\Services\Admin;

use App\Enums\PropertyStatus;
use App\Models\Property;

class ModerasiServiceImpl implements ModerasiService
{
    public function approve(Property $property): void
    {
        $property->status = PropertyStatus::Approved;
        $property->approved_at = now();
        $property->alasan_penolakan = null;
        $property->save();
    }

    public function reject(Property $property, string $alasan): void
    {
        $property->status = PropertyStatus::Rejected;
        $property->approved_at = null;
        $property->alasan_penolakan = $alasan;
        $property->save();
    }
}
