<?php

namespace App\Service;

use App\Entity\Adult;
use App\Entity\Kid;
use Doctrine\ORM\EntityManagerInterface;

class StatisticCollector
{
    public function __construct(
        private EntityManagerInterface $entityManager,
    ) {
    }

    public function getAllData(): array
    {
        $data['kids'] = $this->getAllKids();
        $data['adults'] = $this->getAllAdults();

        return $data;
    }

    public function getAllKids(): array
    {
        $kids  = $this->entityManager->getRepository(Kid::class)->findAll();

        $kidNames = [];
        /** @var Kid $kid */
        foreach ($kids as $kid) {
            $kidNames[] = $kid->getName();
        }

        return $kidNames;
    }

    public function getAllAdults(): array
    {
        $adults  = $this->entityManager->getRepository(Adult::class)->findAll();

        $adultNames = [];

        /** @var Adult $adult */
        foreach ($adults as $adult) {
            $adultNames[] = sprintf('%s %s', $adult->getSurname(), $adult->getName());
        }

        return $adultNames;
    }
}