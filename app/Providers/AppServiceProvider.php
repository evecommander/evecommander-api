<?php

namespace App\Providers;

use App\Doctrine;
use App\Fleet;
use App\Handbook;
use App\Membership;
use App\MembershipLevel;
use App\Observers\DoctrineObserver;
use App\Observers\FleetObserver;
use App\Observers\HandbookObserver;
use App\Observers\MembershipLevelObserver;
use App\Observers\MembershipObserver;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        Doctrine::observe(DoctrineObserver::class);
        Fleet::observe(FleetObserver::class);
        Handbook::observe(HandbookObserver::class);
        MembershipLevel::observe(MembershipLevelObserver::class);
        Membership::observe(MembershipObserver::class);
    }

    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        //
    }
}
