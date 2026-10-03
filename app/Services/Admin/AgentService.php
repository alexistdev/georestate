<?php

namespace App\Services\Admin;

use App\Models\Agent;

interface AgentService
{
    /**
     * Suspend agen: tidak bisa login dan semua listing-nya hilang dari website.
     */
    public function suspend(Agent $agent, string $alasan): void;

    public function aktifkan(Agent $agent): void;

    /**
     * Hapus (soft delete) agen beserta akun user-nya; bisa dipulihkan.
     */
    public function hapus(Agent $agent): void;

    public function pulihkan(Agent $agent): void;
}
