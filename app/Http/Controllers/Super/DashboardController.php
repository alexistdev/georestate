<?php

namespace App\Http\Controllers\Super;

use App\Enums\Role;
use App\Http\Controllers\Admin\DashboardController as AdminDashboardController;
use App\Models\User;

/**
 * Dashboard super admin = dashboard admin + ringkasan akun admin.
 */
class DashboardController extends AdminDashboardController
{
    public function index()
    {
        return view('admin.dashboard', array_merge($this->data(), [
            'judul' => "Dashboard Super Administrator | GeoRestate v.1.0",
            'jumlahAdmin' => User::whereHas('role', fn ($q) => $q->where('name', Role::Admin->value))->count(),
        ]));
    }
}
