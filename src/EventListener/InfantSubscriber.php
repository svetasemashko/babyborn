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
        try {
            $newborn = $event->getNewborn();
            $infant = new Infant($newborn);

            $this->em->persist($infant);
            $this->em->flush();
            $this->em->getConnection()->commit();
        } catch (\Exception $exception) {
            $this->em->getConnection()->rollBack();
            throw $exception;
        }
    }
}