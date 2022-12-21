<?php

namespace App\Components\Dto\Wellness;

use Spatie\DataTransferObject\DataTransferObject;

class SubscribeStoreDTO extends DataTransferObject
{
    /**
     * @var string
     */
    public $contact_id;

    /**
     * @var int
     */
    public $telegram = 0;

    /**
     * @var int
     */
    public $email = 0;
}
