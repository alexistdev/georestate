<?php

namespace App\Providers;

use App\Services\Admin\AgentService;
use App\Services\Admin\AgentServiceImpl;
use App\Services\Admin\DistrictServiceImpl;
use App\Services\Admin\DistrictService;
use App\Services\Admin\ModerasiService;
use App\Services\Admin\ModerasiServiceImpl;
use App\Services\Agen\PropertyService;
use App\Services\Agen\PropertyServiceImpl;
use App\Services\Agen\ProfilService;
use App\Services\Agen\ProfilServiceImpl;
use Illuminate\Pagination\Paginator;
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
        DistrictService::class => DistrictServiceImpl::class,
        ModerasiService::class => ModerasiServiceImpl::class,
        PropertyService::class => PropertyServiceImpl::class,
        ProfilService::class => ProfilServiceImpl::class,
    ];

    public function register(): void
    {
        //
    }

    public function boot(): void
    {
        Paginator::useBootstrapFive();
    }
}
