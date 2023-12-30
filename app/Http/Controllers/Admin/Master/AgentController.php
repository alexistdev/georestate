<?php

namespace App\Http\Controllers\Admin\Master;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Services\Admin\AgentService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AgentController extends Controller
{
    protected $users;
    protected AgentService $agentService;

    public function __construct(AgentService $agentService)
    {
        $this->middleware(function ($request, $next) {
            $this->users = Auth::user();
            return $next($request);
        });
        $this->agentService =$agentService;
    }

    public function index(Request $request)
    {

        if ($request->ajax()) {
            return $this->agentService->index($request);
        }
        return view('admin.agent', array(
            'judul' => "Dashboard Administrator | GeoRestate v.1.0",
            'menuUtama' => 'dashboard',
            'menuKedua' => 'dashboard',
        ));
    }
}
