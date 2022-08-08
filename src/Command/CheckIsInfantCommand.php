<?php

namespace App\Command;

use App\Entity\Kid;
use App\Enum\InfantEnum;
use App\Event\BecameInfantEvent;
use App\Repository\KidRepository;
use DateTime;
use Doctrine\ORM\EntityManagerInterface;
use Exception;
use Monolog\Logger;
use Symfony\Component\Console\Attribute\AsCommand;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Contracts\EventDispatcher\EventDispatcherInterface;

#[AsCommand(
    name: 'app:check-is-infant',
    description: 'Check is age suits to become infant.',
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
        /** @var KidRepository $repository */
        $repository = $this->entityManager->getRepository(Kid::class);

        $dateToBecameInfant = new DateTime();
        $dateToBecameInfant->modify(InfantEnum::getIntervalToBecomeInfant());

        $kidsToBecomeInfant = $repository->findByDateOfBecameInfant($dateToBecameInfant);

        foreach ($kidsToBecomeInfant as $kid) {
            try {
                $event = new BecameInfantEvent($kid);
                $this->dispatcher->dispatch($event, BecameInfantEvent::NAME);
            } catch (Exception $exception) {
                $this->logger->error('Dispatching event has been failed', [
                    'error' => $exception->getMessage(),
                    'code' => $exception->getCode(),
                ]);
            }
        }

        return Command::SUCCESS;
    }
}