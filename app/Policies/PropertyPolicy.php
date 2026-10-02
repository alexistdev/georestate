<?php

namespace App\Policies;

use App\Models\Property;
use App\Models\User;

/**
 * Agen hanya boleh melihat & mengelola listing miliknya sendiri.
 * (Moderasi oleh admin akan ditambahkan di area admin.)
 */
class PropertyPolicy
{
    public function view(User $user, Property $property): bool
    {
        return $this->isOwner($user, $property);
    }

    public function update(User $user, Property $property): bool
    {
        return $this->isOwner($user, $property);
    }

    public function delete(User $user, Property $property): bool
    {
        return $this->isOwner($user, $property);
    }

    private function isOwner(User $user, Property $property): bool
    {
        $agentId = $user->hasAgent?->id;

        return $agentId !== null && $property->agent_id === $agentId;
    }
}
