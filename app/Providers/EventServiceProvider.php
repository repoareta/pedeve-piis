<?php

namespace App\Providers;

use App\Events\InsentifKaryawanKontrak;
use App\Events\InsentifKaryawanTetap;
use App\Events\InsentifSemuaKaryawan;
use App\Events\ProsesInsentif;
use App\Listeners\ProsesInsentifKaryawanKontrak;
use App\Listeners\ProsesInsentifKaryawanTetap;
use Illuminate\Auth\Events\Registered;
use Illuminate\Auth\Listeners\SendEmailVerificationNotification;
use Illuminate\Foundation\Support\Providers\EventServiceProvider as ServiceProvider;
use Illuminate\Support\Facades\Event;

class EventServiceProvider extends ServiceProvider
{
    /**
     * The event listener mappings for the application.
     *
     * @var array
     */
    protected $listen = [
        Registered::class => [
            SendEmailVerificationNotification::class,
        ],
        InsentifKaryawanTetap::class => [
            ProsesInsentifKaryawanTetap::class,
        ],
        InsentifKaryawanKontrak::class => [
            ProsesInsentifKaryawanKontrak::class,
        ],
        InsentifSemuaKaryawan::class => [
            ProsesInsentifKaryawanTetap::class,
            ProsesInsentifKaryawanKontrak::class,
        ],
    ];

    /**
     * Register any events for your application.
     *
     * @return void
     */
    public function boot()
    {
        //
    }
}
