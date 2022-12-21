<?php

namespace App\Http\Requests\Wellness;

use App\Components\Dto\Wellness\UnsubscribeStoreDTO;
use App\Http\Requests\BaseRequest;

class UnsubscribeStoreRequest extends BaseRequest
{

    /**
     * @return string[]
     */
    public function rules(): array
    {
        return [
            'contact_id' => 'required|string',
            'telegram' => 'integer|min:0',
            'email' => 'integer|min:0',
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

            'telegram.integer' => 'Argument telegram must be integer',
            'telegram.min' => 'Argument telegram must be at least 0',
            'email.integer' => 'Argument telegram must be integer',
            'email.min' => 'Argument telegram must be at least 0',
        ];
    }

    /**
     * @return UnsubscribeStoreDTO
     */
    public function getDTO(): UnsubscribeStoreDTO
    {
        return new UnsubscribeStoreDTO([
            'contact_id' => (string)$this->input('contact_id'),
            'telegram' => (int)$this->input('telegram', 0),
            'email' => (int)$this->input('email', 0),
        ]);
    }

}
