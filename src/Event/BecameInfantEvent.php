<?php

namespace App\Event;

use App\Entity\Newborn;
use Symfony\Contracts\EventDispatcher\Event;

class BecameInfantEvent extends Event
{
    public const NAME = 'became.infant';

    public function __construct(
        private Newborn $newborn,
    ) {}

    public function getNewborn(): Newborn
    {
        return $this->newborn;
    }
}