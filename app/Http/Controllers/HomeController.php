<?php

namespace App\Http\Controllers;

use App\Http\Responses\JsonResponse;

class HomeController extends Controller
{
    /**
     * @return JsonResponse
     */
    public function __invoke(): JsonResponse
    {
        return (new JsonResponse())->setResult(true);
    }
}
