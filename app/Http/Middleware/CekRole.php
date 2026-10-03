<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class CekRole
{
    public function handle(Request $request, Closure $next): Response
    {
        // Agen yang disuspend saat sedang login langsung dikeluarkan (status dibaca ulang dari DB).
        $agent = $request->user()?->hasAgent()->first();
        if ($agent?->isSuspend) {
            Auth::guard('web')->logout();
            $request->session()->invalidate();
            $request->session()->regenerateToken();

            return redirect()->route('login')->withErrors(['email' => $agent->pesanSuspend()]);
        }

        $roles = $request->route()->getAction('roles');

        if (!$roles || $request->user()?->hasRole($roles)) {
            return $next($request);
        }

        abort(403, 'Anda tidak memiliki akses ke halaman ini.');
    }
}
