<?php

namespace App\Command;

use App\Entity\Newborn;
use App\Enum\InfantEnum;
use App\Event\BecameInfantEvent;
use App\Repository\NewbornRepository;
use Doctrine\ORM\EntityManagerInterface;
use Monolog\Logger;
use Symfony\Component\Console\Attribute\AsCommand;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Contracts\EventDispatcher\EventDispatcherInterface;

#[AsCommand(
    name: 'app:check-is-infant',
    description: 'Check is age suits for infant.',
    hidden: false,
)]
class CheckIsInfantCommand extends Command
{
    public function __construct(
        private EntityManagerInterface $entityManager,
        private EventDispatcherInterface $dispatcher,
        private Logger $logger,
    )
    {
        parent::__construct();
    }

    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        /** @var NewbornRepository $newbornRepository */
        $newbornRepository = $this->entityManager->getRepository(Newborn::class);

        $dateToBecameInfant = new \DateTime();
        $dateToBecameInfant->modify(InfantEnum::getIntervalToBecomeInfant());

        $newborns = $newbornRepository->findByDateOfBecameInfant($dateToBecameInfant);

        foreach ($newborns as $newborn) {
            try {
                $event = new BecameInfantEvent($newborn);
                $this->dispatcher->dispatch($event, BecameInfantEvent::NAME);
            } catch (\Exception $exception) {
                $this->logger->error('Dispatching event has been failed', [
                    'newbornId' => $newborn->getId(),
                    'error' => $exception->getMessage(),
                    'code' => $exception->getCode(),
                ]);
            }
        }

        return Command::SUCCESS;
    }
}