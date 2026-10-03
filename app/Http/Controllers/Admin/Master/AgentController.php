<?php

namespace App\Http\Controllers\Admin\Master;

use App\Enums\PropertyStatus;
use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\SuspendAgentRequest;
use App\Models\Agent;
use App\Services\Admin\AgentService;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

/**
 * Kelola agen: daftar, detail, suspend/aktifkan, hapus/pulihkan.
 */
class AgentController extends Controller
{
    public const TAB = ['aktif' => 'Aktif', 'suspend' => 'Disuspend', 'terhapus' => 'Terhapus'];

    public function __construct(private readonly AgentService $agentService)
    {
    }

    public function index(Request $request)
    {
        $tab = array_key_exists((string) $request->query('tab'), self::TAB) ? $request->query('tab') : 'aktif';
        $kata = $request->query('q');
        $kata = is_string($kata) && trim($kata) !== '' ? Str::limit(trim($kata), 100, '') : null;

        $agents = $this->queryTab($tab)
            ->with(['hasUser' => fn ($q) => $q->withTrashed(), 'kecamatan'])
            ->withCount([
                'properties as tayang_count' => fn (Builder $q) => $q->where('status', PropertyStatus::Approved),
                'properties as pending_count' => fn (Builder $q) => $q->where('status', PropertyStatus::Pending),
                'properties as ditolak_count' => fn (Builder $q) => $q->where('status', PropertyStatus::Rejected),
            ])
            ->when($kata, function (Builder $q, string $kata) {
                $q->where(function (Builder $q) use ($kata) {
                    $q->where('phone', 'like', "%{$kata}%")
                        ->orWhereHas('hasUser', fn (Builder $u) => $u->withTrashed()
                            ->where(fn (Builder $u) => $u->where('name', 'like', "%{$kata}%")->orWhere('email', 'like', "%{$kata}%")));
                });
            })
            ->latest()
            ->paginate(15)
            ->withQueryString();

        return view('admin.agent', array(
            'judul' => "Kelola Agen | GeoRestate v.1.0",
            'menuUtama' => 'pengguna',
            'menuKedua' => 'agen',
            'dataAgents' => $agents,
            'tab' => $tab,
            'kata' => $kata,
            'jumlahTab' => collect(self::TAB)->map(fn ($label, $key) => $this->queryTab($key)->count()),
        ));
    }

    public function show(Agent $agent)
    {
        $agent->load(['hasUser' => fn ($q) => $q->withTrashed(), 'kecamatan']);

        return view('admin.showagent', array(
            'judul' => "Detail Agen | GeoRestate v.1.0",
            'menuUtama' => 'pengguna',
            'menuKedua' => 'agen',
            'agent' => $agent,
            'dataListing' => $agent->properties()->with('kategori', 'gambarUtama')->latest('updated_at')->get(),
        ));
    }

    public function suspend(SuspendAgentRequest $request, Agent $agent)
    {
        $this->agentService->suspend($agent, $request->validated('alasan_suspend'));

        return redirect(route('adm.agent.show', $agent))
            ->with(['success' => "Agen disuspend. Agen tidak bisa login dan listing-nya disembunyikan dari website."]);
    }

    public function aktifkan(Agent $agent)
    {
        $this->agentService->aktifkan($agent);

        return redirect(route('adm.agent.show', $agent))
            ->with(['success' => "Agen diaktifkan kembali. Listing yang disetujui tampil lagi di website."]);
    }

    public function destroy(Agent $agent)
    {
        $this->agentService->hapus($agent);

        return redirect(route('adm.agent', ['tab' => 'terhapus']))
            ->with(['delete' => "Agen dihapus. Data masih bisa dipulihkan dari tab Terhapus."]);
    }

    public function restore(Agent $agent)
    {
        abort_unless($agent->trashed(), 404);
        $this->agentService->pulihkan($agent);

        return redirect(route('adm.agent.show', $agent))->with(['success' => "Agen berhasil dipulihkan."]);
    }

    private function queryTab(string $tab): Builder
    {
        return match ($tab) {
            'suspend' => Agent::query()->where('isSuspend', true),
            'terhapus' => Agent::onlyTrashed(),
            default => Agent::query()->where('isSuspend', false),
        };
    }
}
