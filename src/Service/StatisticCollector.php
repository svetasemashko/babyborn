<?php

namespace App\Service;

use App\Entity\Adult;
use App\Entity\Kid;
use DateTime;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\EntityManagerInterface;

class StatisticCollector
{
    public function __construct(
        private EntityManagerInterface $entityManager,
    ) {
    }

    public function getAllData(): array
    {
        $data['kids'] = $this->getKidNames($this->getAllKids());
        $data['adults'] = $this->getAdultNames($this->getAllAdults());
        $data['youngestKids'] =
            $this->getKidNames($this->entityManager->getRepository(Kid::class)->findAllByMinAge());
        $data['adultsOfBornThisMonth'] = $this->getAdultNames($this->getAdultsOfBornThisMonth());

        return $data;
    }

    public function getKidNames(ArrayCollection $kidCollection): array
    {
        $kidNames = [];
        /** @var Kid $kid */
        foreach ($kidCollection as $kid) {
            $kidNames[] = $kid->getName();
        }

        return $kidNames;
    }

    public function getAdultNames(ArrayCollection $adultCollection): array
    {
        $adultNames = [];
        /** @var Adult $adult */
        foreach ($adultCollection as $adult) {
            $adultNames[] = sprintf('%s %s', $adult->getSurname(), $adult->getName());
        }

        return $adultNames;
    }

    public function getAllKids(): ArrayCollection
    {
        $kids = $this->entityManager->getRepository(Kid::class)->findAll();

        return new ArrayCollection($kids);
    }

    public function getAllAdults(): ArrayCollection
    {
        $adults  = $this->entityManager->getRepository(Adult::class)->findAll();

        return new ArrayCollection($adults);
    }

    public function getAdultsOfBornThisMonth(): ArrayCollection
    {
        $adultCollection = $this->entityManager->getRepository(Adult::class)->findAllWithKids();

        return $adultCollection->filter(
            function (Adult $adult) {
                $thisMonth = new DateTime();

                return $adult->getKid()->getDateOfBirth()->format('m') === $thisMonth->format('m');
            }
        );
    }
}