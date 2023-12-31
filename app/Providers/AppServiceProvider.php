<?php

namespace App\Providers;

use App\Services\Admin\AgentService;
use App\Services\Admin\AgentServiceImpl;
use App\Services\Admin\DisctrictServiceImpl;
use App\Services\Admin\DistrictService;
use App\Services\Agen\PropertyService;
use App\Services\Agen\PropertyServiceImpl;
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
        AgentService::class =>AgentServiceImpl::class,
        DistrictService::class => DisctrictServiceImpl::class,
        PropertyService::class => PropertyServiceImpl::class,
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
