<?php

namespace App\EventListener;

use App\Entity\Infant;
use App\Event\BecameInfantEvent;
use Doctrine\ORM\EntityManagerInterface;
use Monolog\Logger;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;

class InfantSubscriber implements EventSubscriberInterface
{
    public function __construct(
        private EntityManagerInterface $em,
        private Logger $logger
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
            $this->logger->debug('Infant has been created', [
                'infantId' => $infant->getId(),
            ]);
        } catch (\Exception $exception) {
            $this->logger->error('Event has been failed. Rolled back', [
                'newbornId' => $newborn->getId(),
                'error' => $exception->getMessage(),
                'code' => $exception->getCode(),
            ]);
            $this->em->getConnection()->rollBack();
            throw $exception;
        }
    }
}