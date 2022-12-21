<?php

namespace App\Events;

use Illuminate\Queue\SerializesModels;

abstract class BaseEvent
{
    use SerializesModels;
}
