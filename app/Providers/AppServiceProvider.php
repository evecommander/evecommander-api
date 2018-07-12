<?php

namespace App\Providers;

use App\Comment;
use App\Doctrine;
use App\Fleet;
use App\Handbook;
use App\Invoice;
use App\Membership;
use App\MembershipLevel;
use App\Observers\CommentObserver;
use App\Observers\DoctrineObserver;
use App\Observers\FleetObserver;
use App\Observers\HandbookObserver;
use App\Observers\InvoiceObserver;
use App\Observers\MembershipLevelObserver;
use App\Observers\MembershipObserver;
use App\Observers\ReplacementClaimObserver;
use App\ReplacementClaim;
use CloudCreativity\LaravelJsonApi\Facades\JsonApi;
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
        JsonApi::defaultApi('v1');

        // register model observers
        Comment::observe(CommentObserver::class);
        Doctrine::observe(DoctrineObserver::class);
        Fleet::observe(FleetObserver::class);
        Handbook::observe(HandbookObserver::class);
        Invoice::observe(InvoiceObserver::class);
        MembershipLevel::observe(MembershipLevelObserver::class);
        Membership::observe(MembershipObserver::class);
        ReplacementClaim::observe(ReplacementClaimObserver::class);
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
