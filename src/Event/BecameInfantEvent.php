<?php

namespace App\Event;

use App\Entity\Kid;
use Symfony\Contracts\EventDispatcher\Event;

class BecameInfantEvent extends Event
{
    public const NAME = 'became.infant';

    public function __construct(
        private Kid $kid,
    ) {}

    public function getKid(): Kid
    {
        return $this->kid;
    }
}