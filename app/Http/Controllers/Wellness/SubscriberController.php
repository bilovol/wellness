<?php

namespace App\Http\Controllers\Wellness;

use App\Http\Controllers\Controller;
use App\Http\Requests\Wellness\SubscribeStoreRequest;
use App\Http\Requests\Wellness\UnsubscribeStoreRequest;
use App\Http\Responses\JsonResponse;
use App\Services\Wellness\SubscriberStoreService;
use App\Services\Wellness\UnsubscribeStoreService;

class SubscriberController extends Controller
{
    /**
     * @param SubscribeStoreRequest $request
     * @param SubscriberStoreService $service
     * @return JsonResponse
     */
    public function subscribe(SubscribeStoreRequest $request, SubscriberStoreService $service): JsonResponse
    {
        return (new JsonResponse())->setResult($service->boot($request->getDTO()));
    }

    /**
     * @param UnsubscribeStoreRequest $request
     * @param UnsubscribeStoreService $service
     * @return JsonResponse
     */
    public function unsubscribe(UnsubscribeStoreRequest $request, UnsubscribeStoreService $service): JsonResponse
    {
        return (new JsonResponse())->setResult($service->boot($request->getDTO()));
    }

}
