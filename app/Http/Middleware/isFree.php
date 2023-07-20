<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Symfony\Component\HttpFoundation\Response;

class isFree
{
    /**
         * Author: AlexistDev
         * Email: Alexistdev@gmail.com
         * Phone: 082371408678
         * Github: https://github.com/alexistdev
         */

    public function handle(Request $request, Closure $next): Response
    {
        $countUsers = DB::table('users')->get()->count();
        if($countUsers >= 20){
            abort('401', 'NOT AUTH');
        }
        return $next($request);
    }
}
