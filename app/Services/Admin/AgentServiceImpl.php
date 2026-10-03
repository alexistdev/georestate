<?php

namespace App\Services\Admin;

use App\Models\Agent;
use Illuminate\Support\Facades\DB;

class AgentServiceImpl implements AgentService
{
    public function suspend(Agent $agent, string $alasan): void
    {
        $agent->forceFill([
            'isSuspend' => true,
            'alasan_suspend' => $alasan,
            'suspended_at' => now(),
        ])->save();
    }

    public function aktifkan(Agent $agent): void
    {
        $agent->forceFill([
            'isSuspend' => false,
            'alasan_suspend' => null,
            'suspended_at' => null,
        ])->save();
    }

    public function hapus(Agent $agent): void
    {
        DB::transaction(function () use ($agent) {
            $agent->hasUser()->first()?->delete();
            $agent->delete();
        });
    }

    public function pulihkan(Agent $agent): void
    {
        DB::transaction(function () use ($agent) {
            $agent->restore();
            $agent->hasUser()->withTrashed()->first()?->restore();
        });
    }
}
