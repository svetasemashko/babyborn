<?php

namespace App\EventListener;

use App\Event\BecameInfantEvent;
use Doctrine\DBAL\Exception;
use Doctrine\ORM\EntityManagerInterface;
use JetBrains\PhpStorm\ArrayShape;
use Monolog\Logger;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;

class InfantSubscriber implements EventSubscriberInterface
{
    public function __construct(
        private EntityManagerInterface $em,
        private Logger $logger
    ) {}

    #[ArrayShape([BecameInfantEvent::NAME => "string"])] public static function getSubscribedEvents()
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

            $this->em->remove($kid->getState());
            $kid->becomeOlder();

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