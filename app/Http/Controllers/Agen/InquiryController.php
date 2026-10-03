<?php

namespace App\Http\Controllers\Agen;

use App\Enums\InquiryStatus;
use App\Http\Controllers\Controller;
use App\Models\Agent;
use App\Models\Inquiry;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\Rule;

/**
 * Kotak masuk pertanyaan calon penyewa untuk agen.
 */
class InquiryController extends Controller
{
    public function index(Request $request)
    {
        $status = InquiryStatus::tryFrom((string) $request->query('status'));

        $pertanyaan = $this->agent()->inquiries()
            ->when($status, fn ($q) => $q->where('status', $status))
            ->with('property')
            ->latest()
            ->paginate(15)
            ->withQueryString();

        return view('agen.pertanyaan', array(
            'title' => "Pertanyaan | GeoRestate v.1.0",
            'menuUtama' => 'pertanyaan',
            'menuKedua' => 'pertanyaan',
            'dataPertanyaan' => $pertanyaan,
            'status' => $status,
            'jumlah' => $this->agent()->inquiries()->selectRaw('status, count(*) as total')->groupBy('status')->pluck('total', 'status'),
        ));
    }

    public function show(Inquiry $inquiry)
    {
        $this->pastikanMilikAgen($inquiry);

        if ($inquiry->read_at === null) {
            $inquiry->forceFill(['read_at' => now()])->save();
        }
        $inquiry->load('property');

        return view('agen.showpertanyaan', array(
            'title' => "Pertanyaan | GeoRestate v.1.0",
            'menuUtama' => 'pertanyaan',
            'menuKedua' => 'pertanyaan',
            'inquiry' => $inquiry,
        ));
    }

    public function updateStatus(Request $request, Inquiry $inquiry)
    {
        $this->pastikanMilikAgen($inquiry);
        $data = $request->validate([
            'status' => ['required', Rule::enum(InquiryStatus::class)],
        ], ['status.required' => 'Status wajib dipilih!', 'status.enum' => 'Status tidak valid!']);

        $inquiry->forceFill(['status' => $data['status']])->save();

        return back()->with(['success' => "Status pertanyaan diubah menjadi \"{$inquiry->status->label()}\"."]);
    }

    private function agent(): Agent
    {
        $agent = Auth::user()->hasAgent;
        abort_if($agent === null, 403, 'Data agen tidak ditemukan. Silahkan hubungi administrator.');

        return $agent;
    }

    private function pastikanMilikAgen(Inquiry $inquiry): void
    {
        abort_unless($inquiry->agent_id === $this->agent()->id, 403);
    }
}
