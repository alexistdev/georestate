<?php

namespace App\Providers;

use App\Services\Admin\AgentService;
use App\Services\Admin\AgentServiceImpl;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{

    /**
     * Author: AlexistDev
     * Email: Alexistdev@gmail.com
     * Phone: 082371408678
     * Github: https://github.com/alexistdev
     */

    public $bindings = [
        AgentService::class =>AgentServiceImpl::class
    ];

    public function register(): void
    {
        //
    }

    public function boot(): void
    {
        //
    }
}
