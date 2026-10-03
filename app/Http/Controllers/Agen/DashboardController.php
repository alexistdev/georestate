<?php

namespace App\Http\Controllers\Agen;

use App\Enums\InquiryStatus;
use App\Enums\PropertyStatus;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;

class DashboardController extends Controller
{
    /** Listing disetujui dalam rentang hari ini ditampilkan sebagai notifikasi */
    private const HARI_NOTIFIKASI = 7;

    public function index()
    {
        $agent = Auth::user()->hasAgent;
        abort_if($agent === null, 403, 'Data agen tidak ditemukan. Silahkan hubungi administrator.');

        $jumlah = $agent->properties()
            ->selectRaw('status, count(*) as total')
            ->groupBy('status')
            ->pluck('total', 'status');

        return view('agen.dashboard', array(
            'title' => "Dashboard Agency | GeoRestate v.1.0",
            'menuUtama' => 'dashboard',
            'menuKedua' => 'dashboard',
            'jumlahTayang' => (int) ($jumlah[PropertyStatus::Approved->value] ?? 0),
            'jumlahPending' => (int) ($jumlah[PropertyStatus::Pending->value] ?? 0),
            'jumlahDitolak' => (int) ($jumlah[PropertyStatus::Rejected->value] ?? 0),
            'ditolak' => $agent->properties()
                ->where('status', PropertyStatus::Rejected)
                ->latest('updated_at')
                ->get(),
            'baruDisetujui' => $agent->properties()
                ->where('status', PropertyStatus::Approved)
                ->where('approved_at', '>=', now()->subDays(self::HARI_NOTIFIKASI))
                ->latest('approved_at')
                ->get(),
            'hariNotifikasi' => self::HARI_NOTIFIKASI,
            'pertanyaanBaru' => $agent->inquiries()->where('status', InquiryStatus::Baru)->count(),
            'profilKurang' => array_keys(array_filter([
                'foto profil' => empty($agent->gambar),
                'wilayah (kecamatan)' => empty($agent->kecamatan_id),
                'deskripsi Tentang Saya' => empty($agent->about),
            ])),
        ));
    }
}
