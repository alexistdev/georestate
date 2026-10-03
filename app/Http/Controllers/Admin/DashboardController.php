<?php

namespace App\Http\Controllers\Admin;

use App\Enums\PropertyStatus;
use App\Enums\Role;
use App\Http\Controllers\Controller;
use App\Models\Agent;
use App\Models\ContactMessage;
use App\Models\Property;
use App\Models\User;

class DashboardController extends Controller
{
    public function index()
    {
        $jumlahListing = Property::selectRaw('status, count(*) as total')->groupBy('status')->pluck('total', 'status');

        return view('admin.dashboard', array(
            'judul' => "Dashboard Administrator | GeoRestate v.1.0",
            'menuUtama' => 'dashboard',
            'menuKedua' => 'dashboard',
            'listingTayang' => (int) ($jumlahListing[PropertyStatus::Approved->value] ?? 0),
            'listingPending' => (int) ($jumlahListing[PropertyStatus::Pending->value] ?? 0),
            'listingDitolak' => (int) ($jumlahListing[PropertyStatus::Rejected->value] ?? 0),
            'agenAktif' => Agent::aktif()->count(),
            'agenSuspend' => Agent::where('isSuspend', true)->count(),
            'jumlahUser' => User::whereHas('role', fn ($q) => $q->where('name', Role::User->value))->count(),
            'pesanBaru' => ContactMessage::whereNull('read_at')->count(),
            'antrean' => Property::where('status', PropertyStatus::Pending)
                ->with('agent.hasUser', 'kategori')
                ->oldest('updated_at')
                ->limit(5)
                ->get(),
            'pesanTerbaru' => ContactMessage::latest()->limit(5)->get(),
        ));
    }
}
