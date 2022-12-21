<?php

namespace App\Http\Middleware;

use App\Exceptions\UnauthorizedException;
use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class WellnessSecure
{

    const CUSTOM_HEADER = 'X-Wellness';

    /**
     * @param Request $request
     * @param Closure $next
     * @return mixed
     * @throws UnauthorizedException
     */
    public function handle(Request $request, Closure $next)
    {
        if (!$request->hasHeader(self::CUSTOM_HEADER) || $request->header(self::CUSTOM_HEADER) !== config('wellness.secure')) {
            throw new UnauthorizedException();
        }

        return $next($request);
    }
}
