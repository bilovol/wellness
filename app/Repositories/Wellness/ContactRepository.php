<?php
declare(strict_types=1);

namespace App\Repositories\Wellness;

use App\Models\Wellness\Contact;
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
     * @param int $id
     * @param array $columns
     * @return Builder|Model|object|null
     */
    public function getById(int $id, array $columns = ['*'])
    {
        return $this->model
            ->where('id', $id)
            ->first($columns);
    }

    /**
     * @param string $contact_id
     * @return Builder|Model|object|null
     */
    public function getByContactId(string $contact_id)
    {
        return $this->model
            ->where('contact_id', $contact_id)
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
