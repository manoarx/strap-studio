<?php

namespace App\Providers;

use SMSGlobal\Credentials;
use SMSGlobal\Resource\Sms;
use Illuminate\Support\ServiceProvider;

class SMSGlobalServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     *
     * @return void
     */
    public function register()
    {
        $this->app->bind('smsglobal', function () {
            // Load the SMSGlobal API keys from the config file
            Credentials::set(config('smsglobal.api_key'), config('smsglobal.secret_key'));

            return new Sms();
        });
    }

    /**
     * Bootstrap services.
     *
     * @return void
     */
    public function boot()
    {
        //
    }
}
