<?php

namespace App\EventListener;

use App\Entity\States\Kid\Infant;
use App\Event\BecameInfantEvent;
use Doctrine\DBAL\Exception;
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

    /**
     * @throws Exception
     */
    public function createInfant(BecameInfantEvent $event)
    {
        $this->em->getConnection()->beginTransaction();
        try {
            $kid = $event->getKid();

            $infant = new Infant();
            $kid->transitionTo($infant);

            $this->em->persist($infant);
            $this->em->persist($kid);
            $this->em->flush();

            $this->em->getConnection()->commit();

            $this->logger->info('Kid state has been changed to Infant', [
                'kidId' => $kid->getId(),
            ]);
        } catch (Exception $exception) {
            $this->logger->error('Event has been failed. Rolled back', [
                'error' => $exception->getMessage(),
                'code' => $exception->getCode(),
            ]);
            $this->em->getConnection()->rollBack();

            throw $exception;
        }
    }
}