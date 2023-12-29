<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class OnlyAjax
{
    /**
         * Author: AlexistDev
         * Email: Alexistdev@gmail.com
         * Phone: 082371408678
         * Github: https://github.com/alexistdev
         */

    public function handle(Request $request, Closure $next): Response
    {
        if ( ! $request->ajax())
            return abort(404, 'NOT FOUND');

        return $next($request);
    }
}
