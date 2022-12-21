<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use App\Http\Requests\BaseRequest;

class RequestServiceProvider extends ServiceProvider
{
    /**
     * @return void
     */
    public function register()
    {
        //
    }

    /**
     * @return void
     */
    public function boot()
    {
        $this->app->afterResolving(BaseRequest::class, function ($resolved) {
            $resolved->validateResolved();
        });

        $this->app->resolving(BaseRequest::class, function ($request, $app) {
            $request = BaseRequest::createFrom($app['request'], $request);
            $request->setContainer($app);
        });
    }
}
