<?php

namespace App\EventListener;

use App\Entity\Infant;
use App\Event\BecameInfantEvent;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;

class InfantSubscriber implements EventSubscriberInterface
{
    public function __construct(
        private EntityManagerInterface $em,
    ) {}

    public static function getSubscribedEvents()
    {
        return [
            BecameInfantEvent::NAME => 'createInfant',
        ];
    }

    public function createInfant(BecameInfantEvent $event)
    {
        $newborn = $event->getNewborn();
        $infant = new Infant();
        $infant->setName($newborn->getName())
            ->setDateOfBirth($newborn->getDateOfBirth())
            ->setSex($newborn->getSex());

        $this->em->persist($infant);
        $this->em->flush();
        // clone newborn entity to infant entity
    }
}