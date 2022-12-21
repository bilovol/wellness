<?php

namespace App\Services\Wellness;


use App\Components\Dto\Wellness\SubscribeStoreDTO;
use App\Models\Wellness\Contact;
use App\Repositories\Wellness\ContactRepository;

class SubscriberStoreService
{
    public $repository;

    public function __construct()
    {
        $this->repository = new ContactRepository();
    }

    /**
     * @param SubscribeStoreDTO $storeDTO
     * @return bool
     */
    public function boot(SubscribeStoreDTO $storeDTO): bool
    {
        $contact = $this->repository->getOrFailByContactId($storeDTO->contact_id);

        /** @var Contact $contact */
        return (bool)$this->repository->update($contact->id, [
            'telegram' => $contact->telegram + $storeDTO->telegram,
            'email' => $contact->email + $storeDTO->email,
        ]);
    }
}
