<?php

namespace App\Providers;


use App\StudentResult;
use App\ExamRemark;
use App\StudentAttendance;
use App\InvoiceMaster;

use App\Observers\StudentResultObserver;
use App\Observers\ExamRemarkObserver;
use App\Observers\StudentAttendanceObserver;
use App\Observers\InvoiceMasterObserver;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\URL;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        StudentResult::observe(StudentResultObserver::class);
        ExamRemark::observe(ExamRemarkObserver::class);
        StudentAttendance::observe(StudentAttendanceObserver::class);
        InvoiceMaster::observe(InvoiceMasterObserver::class);

        // Load custom system configuration
        $this->loadSystemConfiguration();

        if (config('app.ssl')) { 
            URL::forceScheme('https');
        }
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

    /**
     * Dynamically load system configuration from systemInfo.php
     *
     * @return void
     */
    protected function loadSystemConfiguration()
    {

        // this should use tenancy var maybe this method load any other place b/c in here tenancy is null
        $smtp = config('systemInfo.general.smtp');
        $general = config('systemInfo.general');

        // $smtp = tenancy()->tenant->system_info['general']['smtp'];
        // $general = tenancy()->tenant->system_info['general'];

        if (!empty($smtp['host'])) {
            Config::set('mail.driver', 'smtp');

            Config::set('mail.host', $smtp['host']);
            Config::set('mail.port', $smtp['port']);
            Config::set('mail.encryption', $smtp['encryption']);
            Config::set('mail.username', $smtp['username']);
            Config::set('mail.password', $smtp['password']);

            Config::set('mail.from.address', $general['contact_email']);
            Config::set('mail.from.name', $general['name']);
        }
    }
}
