<?php

namespace App\Services\Agen;

use Illuminate\Http\Request;

interface PropertyService
{
    public function save(Request $request, string $agentId);
}
