<?php

namespace App\View\Components\Agent;

use App\Enums\InquiryStatus;
use App\Models\Inquiry;
use Closure;
use Illuminate\Contracts\View\View;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\Component;

class AgentMenuSidebarLayout extends Component
{
    public $menuUtama;
    public $menuKedua;
    public int $jumlahPertanyaanBaru = 0;

    public function __construct($menuUtama, $menuKedua)
    {
        $this->menuUtama = $menuUtama;
        $this->menuKedua = $menuKedua;

        $agentId = Auth::user()?->hasAgent?->id;
        if ($agentId) {
            $this->jumlahPertanyaanBaru = Inquiry::where('agent_id', $agentId)
                ->where('status', InquiryStatus::Baru)
                ->count();
        }
    }

    public function render(): View|Closure|string
    {
        return view('components.agent.agent-menu-sidebar-layout');
    }
}
