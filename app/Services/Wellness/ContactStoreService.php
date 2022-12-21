<?php

namespace App\Services\Wellness;


use App\Components\Dto\Wellness\ContactStoreDTO;
use App\Models\Wellness\Contact;
use App\Repositories\Wellness\ContactRepository;

class ContactStoreService
{
    public $repository;

    public function __construct()
    {
        $this->repository = new ContactRepository();
    }


    /**
     * @param ContactStoreDTO $storeDTO
     * @return Contact|ContactRepository|\Illuminate\Database\Eloquent\Builder|\Illuminate\Database\Eloquent\Model|object
     */
    public function boot(ContactStoreDTO $storeDTO)
    {
        $contact = $this->repository->getByContactId($storeDTO->contact_id);
        /** @var Contact $contact */
        if (empty($contact)) {
            return $this->repository->create([
                'contact_id' => $storeDTO->contact_id,
                'telegram' => 0,
                'email' => 0,
                'payment' => $storeDTO->payment
            ]);
        }

        $newPayment = $storeDTO->hard_set
            ? $storeDTO->payment
            : $contact->payment + $storeDTO->payment;

        $this->repository->update($contact->id, ['payment' => $newPayment]);
        $contact->payment = $newPayment;

        return $contact;
    }
}
