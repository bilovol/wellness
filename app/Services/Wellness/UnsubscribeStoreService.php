<?php

namespace App\Services\Wellness;

use App\Components\Dto\Wellness\SubscribeStoreDTO;
use App\Models\Wellness\Contact;
use App\Repositories\Wellness\ContactRepository;

class UnsubscribeStoreService
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
        return $this->repository->update($contact->id, [
            'telegram' => max($contact->telegram - $storeDTO->telegram, 0),
            'email' => max($contact->email - $storeDTO->email, 0)
        ]);
    }
}
