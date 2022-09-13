<?php

namespace App\Service;

use App\Entity\States\Kid\State;
use App\Enum\InfantEnum;
use App\Repository\KidRepository;
use DateTime;
use DateTimeInterface;

class KidMapper
{
    public function __construct(
        public KidRepository $repository,
    ) {}

    public function identifyByDateOfBirth(DateTimeInterface $dateOfBirth): string
    {
        $dateToBecameInfant = new DateTime();
        $dateToBecameInfant->modify(InfantEnum::getIntervalToBecomeInfant());

        if ($dateOfBirth < $dateToBecameInfant) {
            return State::INFANT;
        }

        return State::NEWBORN;
    }
}