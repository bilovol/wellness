<?php

namespace App\Http\Controllers\Wellness;

use App\Http\Controllers\Controller;
use App\Http\Requests\Wellness\ContactStoreRequest;
use App\Http\Responses\JsonResponse;
use App\Repositories\Wellness\ContactRepository;
use App\Services\Wellness\ContactStoreService;

class ContactController extends Controller
{
    /**
     * @param ContactStoreRequest $request
     * @param ContactStoreService $service
     * @return JsonResponse
     */
    public function store(ContactStoreRequest $request, ContactStoreService $service): JsonResponse
    {
        return (new JsonResponse($service->boot($request->getDTO())))->setResult(true);
    }

    /**
     * @param $contactId
     * @param ContactRepository $repository
     * @return JsonResponse
     */
    public function show($contactId, ContactRepository $repository): JsonResponse
    {
        return (new JsonResponse($repository->getOrFailByContactId($contactId)))->setResult(true);
    }
}
