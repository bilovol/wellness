<?php
declare(strict_types=1);

namespace App\Repositories\Wellness;

use App\Clients\SendpulseServiceClient;

/**
 * Variable saved into SP
 */
class VariableRepository
{

    /**
     * @var mixed
     */
    private $client;

    public function __construct()
    {
        $this->client = app()->make(SendpulseServiceClient::class);
    }


    /**
     * @param string $contact_id
     * @param int $payment
     * @return array|null
     */
    public function updatePaymentByContactId(string $contact_id, int $payment): ?array
    {
        return $this->client->post('telegram/contacts/setVariable', [
            'contact_id' => $contact_id,
            'variable_name' => 'payment',
            'variable_value' => (string)$payment
        ], true);
    }
}
