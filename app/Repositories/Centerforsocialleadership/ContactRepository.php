<?php
declare(strict_types=1);

namespace App\Repositories\Centerforsocialleadership;

use App\Models\Centerforsocialleadership\Contact;
use App\Repositories\BaseRepository;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;

class ContactRepository extends BaseRepository
{

    public function getModel()
    {
        return Contact::getModel();
    }

    /**
     * @param string $contactId
     * @return Builder|Model|object|null
     */
    public function getByContactId(string $contactId)
    {
        return $this->model
            ->where('contact_id', $contactId)
            ->first();
    }

    /**
     * @param string $contact_id
     * @param array $columns
     * @return Builder|Model
     */
    public function getOrFailByContactId(string $contact_id, array $columns = ['*'])
    {
        return $this->model
            ->where('contact_id', $contact_id)
            ->firstOrFail($columns);
    }

    public function getAllPayments()
    {
        return $this->model
            ->where('payment', '>', 0)
            ->get();
    }

}
