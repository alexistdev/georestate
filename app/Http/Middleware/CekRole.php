<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class CekRole
{
    /**
     * Author: AlexistDev
     * Email: Alexistdev@gmail.com
     * Phone: 082371408678
     * Github: https://github.com/alexistdev
     */

    public function handle(Request $request, Closure $next): Response
    {
        $roles = $this->CekRoute($request->route());
        if ($request->user()->hasRole($roles) || !$roles) {
            if($this->checkIsPremium()){
                return $next($request);
            }
        }
        return abort(401, 'NOT AUTH');
    }

    private function checkIsPremium(): bool
    {
        if (in_array(Auth::user()->role_id, ["3", "4"])) {
            if (Auth::user()->isPremium != 1) {
                return false;
            }
        }
        return true;
    }

    private function CekRoute($route)
    {
        $action = $route->getAction();
        return isset($action['roles']) ? $action['roles'] : null;
    }
}
