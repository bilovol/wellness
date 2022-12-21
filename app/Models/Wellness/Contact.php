<?php

namespace App\Models\Wellness;

use Illuminate\Database\Eloquent\Model;

/**
 * @property int $id
 * @property string $contact_id
 * @property int $telegram
 * @property int $email
 * @property int $payment
 * @method static getModel()
 */
class Contact extends Model
{
    protected $table = 'contacts';
    protected $guarded = ['id'];
}
