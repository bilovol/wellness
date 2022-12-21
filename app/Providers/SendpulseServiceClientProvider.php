<?php

namespace App\Providers;

use App\Clients\SendpulseServiceClient;
use Illuminate\Support\ServiceProvider;

class SendpulseServiceClientProvider extends ServiceProvider
{

    public function register()
    {
        //
    }

    public function boot()
    {
        $this->app->bind(SendpulseServiceClient::class, function () {
            return new SendpulseServiceClient(config('wellness.client_id'), config('wellness.client_secret'));
        });
    }
}
