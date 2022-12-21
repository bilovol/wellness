<?php

namespace App\Components\Dto\Wellness;

use Spatie\DataTransferObject\DataTransferObject;

class ContactStoreDTO extends DataTransferObject
{
    /**
     * @var string
     */
    public $contact_id;

    /**
     * @var int
     */
    public $payment = 0;

    /**
     * @var bool
     */
    public $hard_set = false;

}
