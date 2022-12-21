<?php

namespace App\Http\Requests\Wellness;

use App\Components\Dto\Wellness\ContactStoreDTO;
use App\Http\Requests\BaseRequest;

class ContactStoreRequest extends BaseRequest
{

    /**
     * @return string[]
     */
    public function rules(): array
    {
        return [
            'contact_id' => 'required|string',
            'payment_time' => 'required|integer|min:0',
            'hard_set' => 'boolean'
        ];
    }

    /**
     * @return string[]
     */
    public function messages(): array
    {
        return [
            'contact_id.required' => 'Argument contact_id required',
            'contact_id.string' => 'Argument contact_id must be string',

            'payment_time.required' => 'Argument payment required',
            'payment_time.integer' => 'Argument email must be integer',
            'payment_time.min' => 'Argument payment_time must be at least 0',
            'hard_set.boolean' => 'Argument hard_set must be boolean',
        ];
    }

    /**
     * @return ContactStoreDTO
     */
    public function getDTO(): ContactStoreDTO
    {
        return new ContactStoreDTO([
            'contact_id' => (string)$this->input('contact_id'),
            'payment' => (int)$this->input('payment_time', 0),
            'hard_set' => $this->boolean('hard_set', false)
        ]);
    }

}
