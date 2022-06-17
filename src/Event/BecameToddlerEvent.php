<?php

namespace App\Event;

use App\Entity\Infant;
use Symfony\Contracts\EventDispatcher\Event;

class BecameToddlerEvent extends Event
{
    public function __construct(
        protected Infant $infant,
    ) {}
}