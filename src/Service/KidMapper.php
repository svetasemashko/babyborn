<?php

namespace App\Service;


use App\Entity\AbstractKid;
use App\Enum\InfantEnum;

class KidMapper
{
    public function identifyByDateOfBirth(\DateTimeInterface $dateOfBirth): string
    {
        $dateToBecameInfant = new \DateTime();
        $dateToBecameInfant->modify(InfantEnum::getIntervalToBecomeInfant());

        if ($dateOfBirth < $dateToBecameInfant) {
            return AbstractKid::INFANT;
        }

        return AbstractKid::NEWBORN;
    }
}